<?php

$act_id=$hGET['id'];
$table='entry_record';

if($act_id=='assembly')$table.='_as';
if($act_id=='morningCeremony')$table.='_mc';

$student_id=$hGET['std_id'];
$type=$hGET['type'];

$act_data=sSelectTb($systemDb,'activity','*','id='.sQ($act_id));
$act_data=$act_data[0];





$data=array(
    'student_id'=>sQ($student_id),
    'time_entry'=>sQ($act_data['start_time']),
    'time_record'=>'NOW()',
    'time_update'=>'NOW()',
    'checker_id'=>current_user('id'),
    'entry_type'=>sQ($type),
);
$cond='student_id='.sQ($student_id,true);

if(is_numeric($act_id)){
    $data['act_id']=$act_id;
    $cond.=' AND act_id='.sQ($act_id); 
}else{
    $data['date_check']='NOW()';
    $cond.=' AND act_id='.sQ($act_id); 
}

$check_record=sSelectTb($systemDb,$table,'count(*) as c',$cond);


if($check_record[0]['c']>0){
    unset($data['time_record']);
    $result=sUpdateTb($systemDb,$table,$data,$cond);
}else{
    $result=sInsertTb($systemDb,$table,$data);
}

if($result){
    print 'ok';
}else{
    print $systemDb['db']->error;
}