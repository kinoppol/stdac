<?php

load_fun('system_alert');
if($_POST['name']==''){

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;กรุณาระบุชื่อกิจกรรม';
    print genAlert($data);
    exit();

}
if($_POST['start_day']==''){

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;กรุณาระบุวันเริ่มกิจกรรม';
    print genAlert($data);
    exit();

}
if($_POST['start_time']==''){

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;กรุณาระบุเวลาเริ่มต้น';
    print genAlert($data);
    exit();

}
if($_POST['end_day']==''){

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;กรุณาระบุวันสิ้นสุดกิจกรรม';
    print genAlert($data);
    exit();

}
if($_POST['end_time']==''){

    $data['icon']='warning';
    $data['color']='alert-warning';
    $data['text']='&nbsp;กรุณาระบุเวลาสิ้นสุดกิจกรรม';
    print genAlert($data);
    exit();

}

$data=array(
    'name'=>sQ($_POST['name']),
    'start_time'=>sQ($_POST['start_day'].' '.$_POST['start_time']),
    'end_time'=>sQ($_POST['end_day'].' '.$_POST['end_time']),
    'semester'=>sQ($_POST['semester']),
    'year'=>sQ($_POST['year']),
);

$acId=$hGET['id'];
if($acId!=""){
    
$result=sUpdateTb($systemDb,'activity',$data,'id='.$acId);
}else{
$result=sInsertTb($systemDb,'activity',$data);
}

if($result){
    $data['icon']='save';
    $data['color']='alert-success';
    $data['text']='&nbsp;บันทึกสำเร็จ';
    print genAlert($data);

    $systemFoot.='
        <script>
        var myInt;
            $(function(){
                myInt=setInterval(hideModal,2000);
                load_ac();
            });

            function hideModal(){
                $("#addAc").modal("hide");
                $("#editAc").modal("hide");
                
                clearInterval(myInt);
            }
        </script>
    ';
}else{
    $data['icon']='warning';
    $data['color']='alert-danger';
    $data['text']='&nbsp;บันทึกไม่ได้ '.$systemDb['db']->error;
    print genAlert($data);

}
