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
//กิจกรรมกลาง
if($_POST['activity_early_signin']){
    update_system_config('activity_early_signin',$_POST['activity_early_signin']);
}
if($_POST['activity_late_signin']){
    update_system_config('activity_late_signin',$_POST['activity_late_signin']);

}
if($_POST['activity_late_score']){
    update_system_config('activity_late_score',$_POST['activity_late_score']);

}
if($_POST['activity_absent_signin']){
    update_system_config('activity_absent_signin',$_POST['activity_absent_signin']);

}
if($_POST['activity_after_check']){
    update_system_config('activity_after_check',$_POST['activity_after_check']);

}
//แถว
if($_POST['morning_ceremony_start_time']){
    update_system_config('morning_ceremony_start_time',$_POST['morning_ceremony_start_time']);
}
if($_POST['morning_ceremony_end_time']){
    update_system_config('morning_ceremony_end_time',$_POST['morning_ceremony_end_time']);
}
if($_POST['morning_ceremony_force_checking']){
    update_system_config('morning_ceremony_force_checking',$_POST['morning_ceremony_force_checking']);
}
if($_POST['morning_ceremony_early_signin']){
    update_system_config('morning_ceremony_early_signin',$_POST['morning_ceremony_early_signin']);
}
if($_POST['morning_ceremony_late_signin']){
    update_system_config('morning_ceremony_late_signin',$_POST['morning_ceremony_late_signin']);

}
if($_POST['morning_ceremony_late_score']){
    update_system_config('morning_ceremony_late_score',$_POST['morning_ceremony_late_score']);

}
if($_POST['morning_ceremony_absent_signin']){
    update_system_config('morning_ceremony_absent_signin',$_POST['morning_ceremony_absent_signin']);

}
if(!empty($_POST['morning_ceremony_after_check'])||$_POST['morning_ceremony_after_check']==0){
    update_system_config('morning_ceremony_after_check',$_POST['morning_ceremony_after_check']);

}
//คาบกิจกรรม
if($_POST['assembly_early_signin']){
    update_system_config('assembly_early_signin',$_POST['assembly_early_signin']);
}
if($_POST['assembly_late_signin']){
    update_system_config('assembly_late_signin',$_POST['assembly_late_signin']);

}
if($_POST['assembly_late_score']){
    update_system_config('assembly_late_score',$_POST['assembly_late_score']);

}
if($_POST['assembly_absent_signin']){
    update_system_config('assembly_absent_signin',$_POST['assembly_absent_signin']);

}
if($_POST['assembly_after_check']){
    update_system_config('assembly_after_check',$_POST['assembly_after_check']);

}

    $msg=" บันทึกข้อมูลเรียบร้อยแล้ว";
        
    $data['icon']='save';
    $data['color']='alert-success';
    $data['text']=$msg;
    print genAlert($data);
    
?>