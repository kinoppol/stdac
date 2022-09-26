<?php

//ตัวแปร static 
error_reporting(E_ALL);
ini_set('memory_limit', '-1');
//ini_set('max_execution_time', 600);

$method = '';
$url = get_system_config("rms_url").'/api_connection.php';  //URL ของระบบ RMS ที่จะส่งข้อมูลไป
$act_id = 'sendactivity';
$app_name = 'nutty';
$school_id = '01';

$act_ids=array(
    'act'=>1,
    'mc'=>2,
    'as'=>3,
);
//print_r($hGET);


$json_file=APP_PATH.'admin/json/'.$hGET['semester'].'.json';

$data=json_decode(file_get_contents($json_file),true);

$x=0;
foreach ($data as $row) {

    foreach($act_ids as $k=>$v){
	
	$make_call = callAPIConnect($method,$url,$act_id,$app_name,$school_id,$row['semes'],$row['student_id'],$v,$row[$k.'_value']);
	$response = json_decode($make_call, true);
	echo print_r($response);
    $x++;
    
    }
}

/*
$app_name='nutty';
$act_id=1;
$semester=$hGET['semester'];
$url_callback=site_url('ajax/admin/api/rms/semester/'.$semester);

print $url_callback;

$URL=get_system_config("rms_url").'/api_connection.php?app_name='.$app_name.'&act_id='.$act_id.'&url='.urlencode($url_callback);
//print $URL;
$result = file_get_contents($URL);
$semester=str_replace("-", "/", $hGET['semester']);
print "โอนผลกิจกรรม ภาคเรียน ".$semester." ";
print $result;
