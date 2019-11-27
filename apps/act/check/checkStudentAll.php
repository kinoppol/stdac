<?php

$act_id=$hGET['id'];
$student_id=$hGET['std_id'];
$type=$hGET['type'];

$act_data=sSelectTb($systemDb,'activity','*','id='.sQ($act_id));
$act_data=$act_data[0];

if($act_data['group_id']!=''){
    $groups_selected=json_decode($act_data['group_id'],true);
}else{
    $groups_selected=array();
}

$student_data=sSelectTb($systemDb,'std','*','group_id in ('.implode(',',$groups_selected).')');
$students=array();
foreach($student_data as $std){
    array_push($students,$std['student_id']);
}

foreach($students as $std){
$cond='act_id='.sQ($act_id).' AND student_id='.sQ($std,true);

$check_record=sSelectTb($systemDb,'entry_record','count(*) as c',$cond);

$data=array(
    'act_id'=>$act_id,
    'student_id'=>sQ($std,true),
    'time_entry'=>sQ($act_data['start_time']),
    'time_record'=>'NOW()',
    'time_update'=>'NOW()',
    'checker_id'=>current_user('id'),
    'entry_type'=>sQ($type),
);

if($check_record[0]['c']>0){
    unset($data['time_record']);
    $result=sUpdateTb($systemDb,'entry_record',$data,$cond);
}else{
    $result=sInsertTb($systemDb,'entry_record',$data);
}
}

    print 'ok';
