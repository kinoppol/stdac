<?php
$rms=get_system_config("rms_url");
sDeleteTb($systemDb,'std');
$student_count=rms_get_data($rms,'nutty','student',null,$count="yes");

$count_std=$student_count[0]['c'];
print json_encode(array('student_count'=>$count_std));