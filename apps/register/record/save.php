<?php

load_fun('system_alert');

$code=$_POST['qr'];

if(mb_strlen($code)>=10&&mb_strlen($code)<=11){

    $data_insert=array(
        'qr_code'=>$code,
        'std_code'=>$code,
        'time_scan'=>'NOW()',
        'act_id'=>1
    );

    $save=sInsertTb($systemDb,'std_register',$data_insert);

}else{

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;รหัสนักเรียนไม่ถูกต้อง';
    print genAlert($data);
    exit();
}

if($save){
$data['icon']='save';
$data['color']='alert-success';
$data['text']='&nbsp;บันทึกข้อมูลเรียบร้อยแล้ว';
print genAlert($data);
}else{
$data['icon']='warning';
$data['color']='alert-danger';
$data['text']='&nbsp;ไม่สามารบันทึกข้อมูลได้';
print genAlert($data);

}