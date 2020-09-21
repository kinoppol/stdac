<?php

function date2date($start,$end,$dow=false){
    $period = new DatePeriod(
        new DateTime($start),
        new DateInterval('P1D'),
        new DateTime($end)
    );
    if(!$dow)$dow=array(
        0=>false,
        1=>true,
        2=>true,
        3=>true,
        4=>true,
        5=>true,
        6=>false
    );
    $dates=array();
    foreach ($period as $key => $value) {
        if($dow[date('w', strtotime($value->format('Y-m-d')))]){
            $dates[$value->format('Y-m-d')]=true; 
        }    
    }
    return $dates;
}