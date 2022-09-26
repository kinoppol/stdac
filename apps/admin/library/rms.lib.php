<?php
error_reporting(0);
function rms_get_data($rmsurl,$app_name,$data,$limit=null,$count=null){
    $target_url=$rmsurl."/api_connection.php?data=".$data."&app_name=".$app_name."&limit=".$limit."&count=".$count;
    $rawdata=file_get_contents($target_url);
    $json=json_decode($rawdata,true);
    return $json;
}

//วันที่ได้มา 2022-09-26
function callAPIConnect($method, $url, $act_id, $app_name ,$school_id, $semes , $student_id , $activity_id , $activity_value){
    $curl = curl_init();
 
     $data = array(
         'act_id' => ''.$act_id.'',
         'app_name' => ''.$app_name.'',
         'school_id' => ''.$school_id.'',
         'semes' => ''.$semes.'',
         'student_id' => ''.$student_id.'',
         'activity_id' => ''.$activity_id.'',
         'activity_value' => ''.$activity_value.''
     );
 
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
     
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0); 
     curl_setopt($curl, CURLOPT_TIMEOUT, 120); //timeout in seconds
     
    $result = curl_exec($curl);
    if(!$result){die("ไม่สามารถเชื่อมต่อกับระบบ RMS ได้ กรุณาลองใหม่ในภายหลัง...");}
    curl_close($curl);
    return $result;
 }