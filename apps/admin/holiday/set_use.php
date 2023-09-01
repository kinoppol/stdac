<?php
$date=$hGET['date'];
$in_use=$hGET['in_use'];

$data=array('in_use'=>sQ($in_use));

$result=sUpdateTb($systemDb,'holiday',$data,'holiday_date='.sQ($date));

if($result){
    print 'ok';
}else{
    print $systemDb['db']->error;
}