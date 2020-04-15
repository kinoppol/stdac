<?php
load_fun('system_alert');
if($_POST['rms_url']){
    update_system_config('rms_url',$_POST['rms_url']);
}

if($_POST['pass_score_activity']){
    update_system_config('pass_score_activity',$_POST['pass_score_activity']);
}

if($_POST['pass_score_morning_ceremony']){
    update_system_config('pass_score_morning_ceremony',$_POST['pass_score_morning_ceremony']);
}

if($_POST['pass_score_assembly']){
    update_system_config('pass_score_assembly',$_POST['pass_score_assembly']);
}

if($_POST['current_semester']){
    update_system_config('current_semester',$_POST['current_semester']);
}

    $msg=" บันทึกข้อมูลเรียบร้อยแล้ว";
        
    $data['icon']='save';
    $data['color']='alert-success';
    $data['text']=$msg;
    print genAlert($data);
    
?>