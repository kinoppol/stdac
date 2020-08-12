<?php

$app_name='nutty';
$act_id=1;
$url_callback=site_url('ajax/admin/api/rms');

$URL=get_system_config("rms_url").'/api_connection.php?app_name='.$app_name.'&act_id='.$act_id.'&url='.urlencode($url_callback);
$result = file_get_contents($URL);

print $result;
