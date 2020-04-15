<?php

load_fun('system_alert');

//print_r($_POST);

$data=array(
    'semester'=>sQ(get_system_config('current_semester')),
    'group_id'=>$_POST['group_id'],
    'morning_ceremony_checker'=>sQ(implode(',',$_POST['morning_ceremony_checker']),true),
    'assembly_checker'=>sQ(implode(',',$_POST['assembly_checker']),true),
);

$check_exists=sSelectTb($systemDb,'checker','count(*) as c','semester='.sQ($_POST['semester']).' AND group_id='.sQ($_POST['group_id']));
$check_exists=$check_exists[0];
if($check_exists['c']>=1){
    $result=sUpdateTb($systemDb,'checker',$data,'semester='.sQ($_POST['semester']).' AND group_id='.sQ($_POST['group_id']));
}else{
    $result=sInsertTb($systemDb,'checker',$data);
}
if($result){
$msg=" บันทึกข้อมูลเรียบร้อยแล้ว";
    
$data['icon']='save';
$data['color']='alert-success';
$data['text']=$msg;
print genAlert($data);
}else{
    
$msg=" ไม่สามารถบันทึกข้อมูลได้ ".$systemDb->error;
    
$data['icon']='save';
$data['color']='alert-danger';
$data['text']=$msg;
print genAlert($data);
}