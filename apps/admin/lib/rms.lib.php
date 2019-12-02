<?php
error_reporting(0);
function rms_get_data($rmsurl,$app_name,$data){
    $target_url=$rmsurl."/api_connection.php?data=".$data."&app_name=".$app_name;
    $rawdata=file_get_contents($target_url);
    $json=json_decode($rawdata,true);
    return $json;
}
