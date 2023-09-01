<?php
$json_file=APP_PATH.'admin/json/'.$hGET['semester'].'.json';
//print $json_file;
print file_get_contents($json_file);
/*
load_fun('activity');
ini_set('memory_limit', '-1');
//error_reporting(E_ALL);
$std_data=sSelectTb($systemDb,'std','*','1 order by student_id');

$data=array();

$semester=str_replace("-", "/", $hGET['semester']);

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

    return array(
        'total_act'=>$count_ac,
        'checked_act'=>$signAct,
        'percentage'=>$count_ac<1?'100':$signAct/$count_ac*100
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

print json_encode($data);
*/
?>