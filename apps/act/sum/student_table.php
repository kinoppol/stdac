<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

load_fun('activity');

$current_semester=get_system_config("current_semester");
$activity_late_score=$late_score=get_system_config("activity_late_score")/100;
$morning_ceremony_late_score=$late_score=get_system_config("morning_ceremony_late_score")/100;
$assembly_late_score=$late_score=get_system_config("assembly_late_score")/100;

$semester_data=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ($current_semester));
$semester_data=$semester_data[0];

$checker_data=sSelectTb($systemDb,'checker','*','group_id='.$hGET['group'].' AND semester='.sQ(get_system_config('current_semester')));
$checker_data=$checker_data[0];
//print_r($checker_data);

$holiday=sSelectTb($systemDb,'holiday','*','semester = '.sQ(get_system_config('current_semester')));
$holidays=array();
$ignoreDate=array();
foreach($holiday as $row){
    if($row['in_use']=='N'){
        $ignoreDate[]=$row['holiday_date'];
    }else{
        $holidays[]=$row['holiday_date'];
    }
}

    $semester=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ(get_system_config('current_semester')));
    $semester=$semester[0];
    //print_r($semester);


   $dow_assembly=explode(',',$checker_data['assembly_date']);   
   $dow_morning_ceremony=explode(',',$checker_data['morning_ceremony_date']);

    $dates_assembly=date2date($semester['semester_start'],$semester['semester_end'],$dow_assembly,$ignoreDate);
    $dates_morning_ceremony=date2date($semester['semester_start'],$semester['semester_end'],$dow_morning_ceremony,$ignoreDate);
    $date_assembly=count($dates_assembly);
    $date_morning_ceremony=count($dates_morning_ceremony);



$group_id=$hGET['group'];
$activity_pass=get_system_config("pass_score_activity");
$assembly_pass=get_system_config("pass_score_assembly");
$morning_ceremony_pass=get_system_config("pass_score_morning_ceremony");

//$current_semester=$_SESSION['current_semester'];
$current_semester=get_system_config("current_semester");
$current_edu_year=mb_substr($current_semester,2,4);
$current_semester=mb_substr($current_semester,0,1);

$acts=sSelectTb($systemDb,"activity",'*','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' AND group_id like "%'.$group_id.'%"');
$head=array(
    //'ที่',
    'รหัสนักเรียน',
    'ชื่อ',
    'สกุล',
    //'รหัสกลุ่ม',
    //'ระดับชั้น',
    //'ชื่อกลุ่ม',
);
$act_id=array();
foreach($acts as $row){
    array_push($head,'<a href="#" title="'.$row['name'].'">'.mb_substr($row['name'],0,10)).'</a>';
    array_push($act_id,$row['id']);
}
array_push($head,'กิจกรรมกลาง');
if(get_system_config("active_morning_ceremony")=='active')array_push($head,'กิจกรรมหน้าเสาธง');
if(get_system_config("active_assembly")=='active')array_push($head,'คาบกิจกรรม');
array_push($head,'ผลกิจกรรม');

$ac_data=sSelectTb($systemDb,"std",'*','group_id='.$group_id);
//print_r($complaint_data);
$table_data=array();
$i=0;

foreach($ac_data as $row){
    $i++;
    $table_data[$i]=array(
        //'no'=>$i,
        'student_id'=>$row['student_id'],
        'stu_fname'=>$row['stu_fname'],
        'stu_lname'=>$row['stu_lname'],
        //'group_id'=>$row['group_id'],
        //'level_name'=>$row['level_name'],
        //'major_name'=>$row['major_name'],
        //'<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'"><i class="material-icons col-red">search</i></a>'
    );
    
    $signAct=0;
    $lateAct=0;

    foreach($act_id as $act_row){
        $check_data=sSelectTb($systemDb,"entry_record",'*','act_id='.$act_row.' AND student_id='.sQ($row['student_id']));
        if(count($check_data)==0){
            $newData=array(
                'act_id'=>$act_row,
                'student_id'=>sQ($row['student_id']),
                'time_record'=>'NOW()',
                'time_update'=>'NOW()',
                'checker_id'=>current_user('id'),
                'entry_type'=>sQ('unCheck')
            );
            sInsertTb($systemDb,"entry_record",$newData);
            $check_data['entry_type']='unCheck';
        }else{
            $check_data=$check_data[0];
        }
        if($check_data['entry_type']=='check'){
            $table_data[$i][$act_row]='✔';
            $signAct++;
        }else if($check_data['entry_type']=='late'){
            $table_data[$i][$act_row]='ส';
            $lateAct++;
        }else if($check_data['entry_type']=='unCheck'){
            $table_data[$i][$act_row]='✗';
        }else{
            $table_data[$i][$act_row]='';
        }
    }
    if(count($act_id )>0){
        $total_signact=($signAct+($lateAct*$activity_late_score));
        $percentage=$total_signact/count($act_id)*100;
    }else{
        $percentage=100;
    }

    
    $assembly_check_data=sSelectTb($systemDb,'entry_record_as','count(*) as c','student_id='.sQ($row['student_id']).' AND entry_type='.sQ('check').' AND date_check between '.sQ($semester['semester_start']).' AND '.sQ($semester['semester_end']));
    $assembly_check_data=$assembly_check_data['0'];
    $assembly_late_data=sSelectTb($systemDb,'entry_record_as','count(*) as c','student_id='.sQ($row['student_id']).' AND entry_type='.sQ('late').' AND date_check between '.sQ($semester['semester_start']).' AND '.sQ($semester['semester_end']));
    $assembly_late_data=$assembly_late_data['0'];
    
    $total_sign_assembly=($assembly_check_data['c']+($assembly_late_data['c']*$assembly_late_score));
    $assembly_percentage=$total_sign_assembly>0?($total_sign_assembly/$date_assembly*100):0;
    
    $morning_ceremony_check_data=sSelectTb($systemDb,'entry_record_mc','count(*) as c','student_id='.sQ($row['student_id']).' AND entry_type='.sQ('check').' AND date_check between '.sQ($semester['semester_start']).' AND '.sQ($semester['semester_end']));
    $morning_ceremony_check_data=$morning_ceremony_check_data['0'];
    $morning_ceremony_late_data=sSelectTb($systemDb,'entry_record_mc','count(*) as c','student_id='.sQ($row['student_id']).' AND entry_type='.sQ('late').' AND date_check between '.sQ($semester['semester_start']).' AND '.sQ($semester['semester_end']));
    $morning_ceremony_late_data=$morning_ceremony_late_data['0'];
    $total_sign_morning_ceremony=($morning_ceremony_check_data['c']+($morning_ceremony_late_data['c']*$morning_ceremony_late_score));
    $morning_ceremony_percentage=$total_sign_morning_ceremony>0?($total_sign_morning_ceremony/$date_morning_ceremony*100):0;

    if($percentage<$activity_pass){
        $activity_color='style="color:red;"';
        $act_grade='fail';
    }else{
        $activity_color='style="color:green;"';
        $act_grade='pass';
    }
    if($assembly_percentage<$assembly_pass){
        $assembly_color='style="color:red;"';
        $assembly_grade='fail';
    }else{
        $assembly_color='style="color:green;"';
        $assembly_grade='pass';
    }
    if($morning_ceremony_percentage<$morning_ceremony_pass){
        $morning_ceremony_color='style="color:red;"';
        $morning_ceremony_grade='fail';
    }else{
        $morning_ceremony_color='style="color:green;"';
        $morning_ceremony_grade='pass';
    }

    if(get_system_config("active_morning_ceremony")=='active'&&$morning_ceremony_grade=='fail'){
        $act_grade='fail';
    }
    if(get_system_config("active_assembly")=='active'&&$assembly_grade=='fail'){
        $act_grade='fail';
    }

    $table_data[$i]['sumact']='<span '.$activity_color.'>'.$total_signact.' ครั้ง ('.number_format($percentage,2).'%)</span>';
    if(get_system_config("active_morning_ceremony")=='active')$table_data[$i]['sumMorningCeremony']='<span '.$morning_ceremony_color.'>'.$total_sign_morning_ceremony.'/'.$date_morning_ceremony.' ครั้ง ('.number_format($morning_ceremony_percentage,2).'%)</span>';
    if(get_system_config("active_assembly")=='active')$table_data[$i]['sumAssembly']='<span '.$assembly_color.'>'.$total_sign_assembly.'/'.$date_assembly.' ครั้ง ('.number_format($assembly_percentage,2).'%)</span>';
    $table_data[$i]['grade']=$act_grade=="pass"?'<span style="color:green;">ผ่าน</span>':'<span style="color:red;">ไม่ผ่าน</span>';

}


           

$data=array("head"=>$head,
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 0, "asc" ]]'
    );
    print datatable($data);
    ?>
    </div>