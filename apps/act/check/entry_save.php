<?php

load_fun('system_alert');

$student_id=$_POST['student_id'];

$student_data=sSelectTb($systemDb,'std','*','student_id='.$student_id);
if(count($student_data)>0){
$student_data=$student_data[0];

$prefix=array(
    '1'=>'นางสาว',
    '2'=>'นาย',
    '3'=>'เด็กชาย',
    '4'=>'เด็กหญิง',
    '5'=>'นาง',

);

$msg="เช็คชื่อให้ ".$prefix[$student_data['prefix_id']].$student_data['stu_fname']." ".$student_data['stu_lname']." เรียบร้อยแล้ว";

if(true){
    $data['icon']='save';
    $data['color']='alert-success';
    $data['text']=$msg;
    print genAlert($data);
}else{
    $data['icon']='warning';
    $data['color']='alert-danger';
    $data['text']='&nbsp;บันทึกไม่ได้';
    print genAlert($data);

}

}else{

    $msg="รหัสนักศึกษาไม่ถูกต้อง";
    
    $data['icon']='save';
    $data['color']='alert-warning';
    $data['text']=$msg;
    print genAlert($data);
}

$systemFoot.="
    <script>
    $(function(){
        $('#student_id').val('');
    });
    </script>
";

