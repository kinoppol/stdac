<?php
$step=$hGET['step'];
$limitCount=$hGET['limit'];

$limit=$step*$limitCount.','.$limitCount;

$rms=get_system_config("rms_url");
$student_data=rms_get_data($rms,'nutty','student',$limit,null);

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


print json_encode(array('transfered'=>$import_student));