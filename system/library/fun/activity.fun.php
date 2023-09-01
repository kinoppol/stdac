<?php

function date2date($start,$end,$dow=false,$ignore_date=false){
    $period = new DatePeriod(
        new DateTime($start),
        new DateInterval('P1D'),
        new DateTime($end)
    );
    if(!$ignore_date)$ignore_date=array();
    if(!$dow)$dow=array(
        1,2,3,4,5
    );
    $dates=array();
    foreach ($period as $key => $value) {
        if(in_array($value->format('Y-m-d'),$ignore_date))continue;
        if(in_array(date('w', strtotime($value->format('Y-m-d'))),$dow)){
            $dates[$value->format('Y-m-d')]=true; 
        }    
    }
    return $dates;
}