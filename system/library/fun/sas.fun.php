<?php
function get_simple_val($data){
    global $sas_url;   
    $arrg='';
    foreach($data as $k=>$v){
        $arrg.=$k.'/'.$v.'/';
    } 
    $result = file_get_contents($sas_url.'?p=ajax/api/simpleval/file/'.$arrg);
    return $result;
}