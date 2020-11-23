<?php

$act_id=$hGET['id'];
$gid=$hGET['gid'];
$table='entry_record';

if($act_id=='assembly'){
    $table.='_as';
    $date=$hGET['date'];
}
if($act_id=='morningCeremony'){
    $table.='_mc';
    $date=$hGET['date'];
}

//$student_id=$hGET['std_id'];
$type=$hGET['type'];

$act_data=sSelectTb($systemDb,'activity','*','id='.sQ($act_id));
$act_data=$act_data[0];

if($act_data['group_id']!=''){
    $groups_selected=json_decode($act_data['group_id'],true);
}else{
    $groups_selected=array();
}
if($gid){
    $student_data=sSelectTb($systemDb,'std','*','group_id = '.sQ($gid));
}else{
    $student_data=sSelectTb($systemDb,'std','*','group_id in ('.implode(',',$groups_selected).')');
}
$students=array();
foreach($student_data as $std){
    array_push($students,$std['student_id']);
}

foreach($students as $std){


$data=array(
    'student_id'=>sQ($std),
    'time_entry'=>sQ($act_data['start_time']),
    'time_record'=>'NOW()',
    'time_update'=>'NOW()',
    'checker_id'=>current_user('id'),
    'entry_type'=>sQ($type),
);
$cond='student_id='.sQ($std,true);

if(is_numeric($act_id)){
    $data['act_id']=sQ($act_id);
    $cond.=' AND act_id='.sQ($act_id);
}else{
    $data['date_check']=sQ($date);
    $cond.=' AND date_check='.sQ($date); 
}

$check_record=sSelectTb($systemDb,$table,'count(*) as c',$cond);

if($check_record[0]['c']>0){
    unset($data['time_record']);
    $result=sUpdateTb($systemDb,$table,$data,$cond);
    //print "UPDATE";
}else{
    $result=sInsertTb($systemDb,$table,$data);
    //print "INSERT";
}
}

    print 'ok';
