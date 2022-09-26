<?php

$app_name='nutty';
$act_id=1;
$semester=$hGET['semester'];
$url_callback=site_url('ajax/admin/api/rms/semester/'.$semester);

print $url_callback;

$URL=get_system_config("rms_url").'/api_connection.php?app_name='.$app_name.'&act_id='.$act_id.'&url='.urlencode($url_callback);
print $URL;
$result = file_get_contents($URL);
$semester=str_replace("-", "/", $hGET['semester']);
print "โอนผลกิจกรรม ภาคเรียน ".$semester." ";
print $result;
