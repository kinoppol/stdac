<?php

$set_active=$hGET['set'];
$result=false;
if($set_active=='active_assembly'){
    $result=update_system_config('active_assembly','active');
}
if($set_active=='disactive_assembly'){
    $result=update_system_config('active_assembly','disactive');
}

if($set_active=='active_morning_ceremony'){
    $result=update_system_config('active_morning_ceremony','active');
}
if($set_active=='disactive_morning_ceremony'){
    $result=update_system_config('active_morning_ceremony','disactive');
}

if($result)print "ok";