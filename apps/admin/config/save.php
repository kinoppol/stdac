<?php
if($_POST['rms_url']){
    update_system_config('rms_url',$_POST['rms_url']);
}

if($_POST['pass_score']){
    update_system_config('pass_score',$_POST['pass_score']);
}

if($_POST['current_semester']){
    update_system_config('current_semester',$_POST['current_semester']);
}
?>
บันทึกข้อมูลเรียบร้อยแล้ว