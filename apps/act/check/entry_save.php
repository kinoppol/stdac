<?php

$act_id=$hGET['id'];
$student_id=$hGET['std_id'];
$gid=$hGET['gid'];
$table='entry_record';
$date=date('Y-m-d');

if($act_id=='assembly'){
    $table.='_as';
    //$date=$hGET['date'];
}
if($act_id=='morningCeremony'){
    $table.='_mc';
    //$date=$hGET['date'];
}

load_fun('system_alert');

$student_id=$_POST['student_id'];

$student_data=sSelectTb($systemDb,'std','*','student_id='.$student_id.' OR uid='.$student_id);
if(count($student_data)>0){
$student_data=$student_data[0];

$prefix=array(
    '1'=>'นางสาว',
    '2'=>'นาย',
    '3'=>'เด็กชาย',
    '4'=>'เด็กหญิง',
    '5'=>'นาง',

);
$student_name=$student_data['stu_fname']." ".$student_data['stu_lname'];

$cond = ' AND start_time <= '.sQ(date('Y-m-d H:i:s')).' AND end_time >='.sQ(date('Y-m-d H:i:s'));
$act_data=sSelectTb($systemDb,'activity','*','id='.sQ($act_id).$cond);
$act_data=$act_data[0];

if($act_data['group_id']==''){
    $available_group=array();
}else{
    $available_group=json_decode($act_data['group_id'],true);
}

if($gid){
    $available_group=array($gid);
}

if(in_array($student_data['group_id'],$available_group)){


    $cond='student_id='.sQ($student_id,true);

    if(is_numeric($act_id)){
        $cond=' AND act_id='.sQ($act_id);
    }else{
        $data['date_check']=sQ($date);
        $cond.=' AND date_check='.sQ($date); 
    }
    
    $check_record=sSelectTb($systemDb,$table,'count(*) as c',$cond);

$data=array(
    'student_id'=>sQ($student_data['student_id']),
    'time_record'=>'NOW()',
    'time_update'=>'NOW()',
    'checker_id'=>current_user('id'),
    'entry_type'=>sQ('check'),
);

if(is_numeric($act_id)){
    $data['act_id']=$act_id;
    $data['time_entry']=sQ($act_data['start_time']);
}else{
    $data['date_check']=sQ($date);
}

if($check_record[0]['c']>0){
    unset($data['time_record']);
    $result=sUpdateTb($systemDb,$table,$data,$cond);
}else{
    $result=sInsertTb($systemDb,$table,$data);
}


$msg="เช็คชื่อให้ ".$student_name." เรียบร้อยแล้ว";

if($result){
    $data['icon']='save';
    $data['color']='alert-success';
    $data['text']=$msg;
    print genAlert($data);
}else{
    $data['icon']='warning';
    $data['color']='alert-danger';
    $data['text']='&nbsp;บันทึกไม่ได้ '.$systemDb['db']->error;
    print genAlert($data);

}
}else{
    
    $msg=" บัตรประจำตัวของ ".$student_name." นักศึกษาไม่อยู่ในกลุ่มที่ร่วมกิจกรรม, หรือไม่อยู่ในระยะเวลาที่กำหนดให้เข้าร่วมกิจกรรม";
    
    $data['icon']='save';
    $data['color']='alert-warning';
    $data['text']=$msg;
    print genAlert($data);
}

}else{

    $msg="รหัสนักศึกษาไม่ถูกต้อง";
    
    $data['icon']='save';
    $data['color']='alert-warning';
    $data['text']=$msg;
    print genAlert($data);
}

$systemFoot.="
    <script>
    $(function(){
        $('#student_id').val('');
    });
    </script>
";

