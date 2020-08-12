<?php
$import_student=0;
sDeleteTb($systemDb,"std");
//print "Hello";
$rms=get_system_config("rms_url");
$student_count=rms_get_data($rms,'nutty','student',null,$count="yes");

$count_std=$student_count[0]['c'];
$p=ceil($count_std/1000);

//print $p;
//exit();
for($in=0;$in<$p;$in++){

    $limit=($in*1000+0).",1000";
    //print $limit;
$student_data=rms_get_data($rms,'nutty','student',$limit,null);
//sleep(1);
//print_r($student_data);


foreach($student_data as $student){
    if($student['status']==0||true){//0=คือสถานะที่นักเรียนกำลังเรียนอยู่
    $data=array(
        "student_id"=>sQ($student['student_id']),
        //"prefix_id"=>sQ($student['perfix_id']),
        "gender_id"=>sQ($student['gender_id']),
        "stu_fname"=>sQ($student['stu_fname']),
        "stu_lname"=>sQ($student['stu_lname']),
        "group_id"=>sQ($student['group_id']),
        "uid"=>sQ($student['std_rf_id']),
    );
    $result=sInsertTb($systemDb,"std",$data);
    //print_r($result);
    if($result){
        $import_student++;
        //print "1";
    }else{
        print $systemDb['db']->error;
        exit();
    }
}
}

}

$group_data=rms_get_data($rms,'nutty','student_group',null,null);
sDeleteTb($systemDb,"group");
$import_group=0;
foreach($group_data as $group){
    if($group['student_group_hidden']==0){//0=คือสถานะที่นักเรียนกำลังเรียนอยู่
    $data=array(
        "group_id"=>sQ($group['student_group_id']),
        "group_short_name"=>sQ($group['student_group_short_name']),
        "major_name"=>sQ($group['major_name']),
        "minor_name"=>sQ($group['minor_name']),
        "level_name"=>sQ($group['level_name']),
    );
    $result=sInsertTb($systemDb,"group",$data);
    if($result){
        $import_group++;
    }
}
}
?>
                            ข้อมูลผู้เรียนจำนวน <?php print number_format($import_student);?> คนเรียบร้อยแล้ว
