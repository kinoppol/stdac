<?php
load_fun('activity');
ini_set('memory_limit', '-1');
//error_reporting(E_ALL);


if(!empty($hGET['group_id'])){
    $group_id=$hGET['group_id'];
}else{
$group_data=sSelectTb($systemDb,'group','group_id');
//print_r($group_data);
$total_group=count($group_data);
$group_id=$group_data[$hGET['round']]['group_id'];
}

$semester=str_replace("-", "/", $hGET['semester']);

$std_data=sSelectTb($systemDb,'std','*','group_id='.sQ($group_id).' order by student_id');

$data=array();



$semester_data=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ($semester));
$semester_data=$semester_data[0];

$pass_score=get_system_config("pass_score_activity");
$assembly_pass=get_system_config("pass_score_assembly");
$morning_ceremony_pass=get_system_config("pass_score_morning_ceremony");

$morning_ceremony_late_score=$late_score=get_system_config("morning_ceremony_late_score")/100;
$assembly_late_score=$late_score=get_system_config("assembly_late_score")/100;




function ac_result($std_id,$group_id,$semester){
    global $systemDb;

    $semes=mb_substr($semester,0,1);
    $edu_year=mb_substr($semester,2,4);
    $acts=sSelectTb($systemDb,"activity",'*','semester='.sQ( $semes).' AND year='.sQ($edu_year).' AND group_id like "%'.$group_id.'%"');
    $count_ac=count($acts);

    $act_id=array();
foreach($acts as $row){
    array_push($act_id,$row['id']);
}

    foreach($act_id as $act_row){
        $check_data=sSelectTb($systemDb,"entry_record",'*','act_id='.$act_row.' AND student_id='.sQ($row['student_id']));
        $check_data=$check_data[0];
        if($check_data['entry_type']=='check'){
            $signAct++;
        }
    }
    if($count_ac==0){
        $ac_percentage=100;
    }else{
        $ac_percentage=$signAct/$count_ac*100;
    }
    print '('.$signAct.'/'.$count_ac.')'.$ac_percentage."<<";
    return array(
        'total_act'=>$count_ac,
        'checked_act'=>$signAct,
        'percentage'=>$ac_percentage
    );

}
//print "--------------------------------------<br>";
$group_data=sSelectTb($systemDb,'group','group_id','1 order by group_id asc');
$groups=array();
foreach($group_data as $row){
    $groups[]=$row['group_id'];
}

$mc_checking_data=sSelectTb($systemDb,'entry_record_mc','student_id,date_check,entry_type','date_check between '.sQ($semester_data['semester_start']).' AND '.sQ($semester_data['semester_end']));
$as_checking_data=sSelectTb($systemDb,'entry_record_as','student_id,date_check,entry_type','date_check between '.sQ($semester_data['semester_start']).' AND '.sQ($semester_data['semester_end']));

//ข้อมูลวันหยุด-ปิดเรียน
$holiday=sSelectTb($systemDb,'holiday','*','semester = '.sQ($semester));
$holidays=array();
$ignoreDate=array();
foreach($holiday as $row){
    if($row['in_use']=='N'){
        $ignoreDate[]=$row['holiday_date'];
    }else{
        $holidays[]=$row['holiday_date'];
    }
}

//ข้อมูลการเข้าแถว/กิจกรรม อวท.
$checker_data=sSelectTb($systemDb,'checker','group_id,morning_ceremony_date,assembly_date','semester='.sQ($semester));

$dow_check=array();
foreach($checker_data as $row){
    $dow_check[$row['group_id']]=array(
        'morning_ceremony_date'=>explode(',',$row['morning_ceremony_date']),
        'assembly_date'=>explode(',',$row['assembly_date'])
    );
}
$dates_semester=array();
foreach($groups as $row){
    $dates_semester[$row]=array(
        'morning_ceremony'=>date2date($semester_data['semester_start'],$semester_data['semester_end'],$dow_check[$row]['morning_ceremony_date'],$ignoreDate),
        'assembly'=>date2date($semester_data['semester_start'],$semester_data['semester_end'],$dow_check[$row]['assembly_date'],$ignoreDate),
    );
}
//print_r($dates_semester);


foreach($std_data as $row){
    $stdData=array();
    $stdData['student_id']=$row['student_id'];
    $stdData['semes']=$semester;

    $result=ac_result($row['student_id'],$row['group_id'],$semester);
    $mc_result=mc_result($row['student_id'],$row['group_id']);
    $as_result=as_result($row['student_id'],$row['group_id']);

    $stdData['act_percentage']=$result['percentage'];
    $stdData['act_value']=$result['percentage']>=$pass_score?'1':'0';
    $stdData['mc_check']=$mc_result['check'];
    $stdData['mc_late']=$mc_result['late'];
    $stdData['mc_percentage']=$mc_result['percentage'];
    $stdData['mc_value']=$mc_result['percentage']>=$morning_ceremony_pass?'1':'0';
    $stdData['as_check']=$as_result['check'];
    $stdData['as_late']=$as_result['late'];
    $stdData['as_percentage']=$as_result['percentage'];
    $stdData['as_value']=$as_result['percentage']>=$assembly_pass?'1':'0';

    array_push($data,$stdData);
}

function mc_result($student_id,$group_id){
    global $dates_semester;
    global $mc_checking_data;
    global $morning_ceremony_late_score;
    $checking=array();
    //print_r($mc_checking_data);
        foreach($mc_checking_data as $row){
            if($row['student_id']!=$student_id){
                continue;
            }
            $checking[$row['date_check']]=$row['entry_type'];
        }
        //print_r($checking);
    $count=array_count_values($checking);
    $totalCheck=$count['check']+($count['late']*$morning_ceremony_late_score);    
    $cdates=count($dates_semester[$group_id]['morning_ceremony']);
    if($cdates>0){
        $percentage=($totalCheck/$cdates)*100;
    }else{
        $percentage=100;
    }
    $res=array(
        'check'=>$count['check'],
        'unCheck'=>$count['unCheck'],
        'late'=>$count['late'],
        'percentage'=>number_format($percentage,1)
    );
    return $res;
}


function as_result($student_id,$group_id){
    global $dates_semester;
    global $as_checking_data;
    global $assembly_late_score;
    $checking=array();
        foreach($as_checking_data as $row){
            if($row['student_id']!=$student_id){
                continue;
            }
            $checking[$row['date_check']]=$row['entry_type'];
        }
    $count=array_count_values($checking);
    $totalCheck=$count['check']+($count['late']*$assembly_late_score);
    $cdates=count($dates_semester[$group_id]['assembly']);
    if($cdates>0){
        $percentage=($totalCheck/$cdates)*100;
    }else{
        $percentage=100;
    }
    $res=array(
        'check'=>$count['check'],
        'unCheck'=>$count['unCheck'],
        'late'=>$count['late'],
        'percentage'=>number_format($percentage,1)
    );
    return $res;
}
$fname=APP_PATH.'admin/json/'.$hGET['semester'].'.json';
//print $fname;
//if($hGET['round']==0){
    $json_file=fopen($fname,'w');
    $json_data=json_encode($data);
/*}else{
    $old_json=json_decode(file_get_contents($fname),true);

    $json_file=fopen($fname,'w');
    $json_data=json_encode(
        array_merge(
            $old_json,
            $data
        )
    );
}*/
fwrite($json_file,$json_data);
fclose($json_file);
if($hGET['round']<$total_group){
    print 'กำลังประมวลผลกลุ่มที่ '.($hGET['round']+1).' จากทั้งหมด '.$total_group.' กลุ่ม ('.number_format(($hGET['round']+1)/$total_group*100).'%)';
    //sleep(1);
}else{
    print 'ok';
}
///ส่งข้อมูล
error_reporting(E_ALL);
ini_set('memory_limit', '-1');
//ini_set('max_execution_time', 600);

$method = '';
$url = get_system_config("rms_url").'/api_connection.php';  //URL ของระบบ RMS ที่จะส่งข้อมูลไป
$act_id = 'sendactivity';
$app_name = 'nutty';
$school_id = '01';

$act_ids=array(
    'act'=>1,
    'mc'=>2,
    'as'=>3,
);

$json_file=APP_PATH.'admin/json/'.$hGET['semester'].'.json';

$data=json_decode(file_get_contents($json_file),true);

$x=0;
foreach ($data as $row) {

    foreach($act_ids as $k=>$v){
	
	$make_call = callAPIConnect($method,$url,$act_id,$app_name,$school_id,$row['semes'],$row['student_id'],$v,$row[$k.'_value']);
	$response = json_decode($make_call, true);
	//echo print_r($response);
    $x++;
    }
}


print '<br> ส่งข้อมูลทั้งหมด '.$x.' รายการ';
?>