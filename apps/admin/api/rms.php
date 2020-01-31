<?php

$std_data=sSelectTb($systemDb,'std','*','1 order by student_id');

$data=array();

$semester=get_system_config("current_semester");
$pass_score=get_system_config("pass_score");

foreach($std_data as $row){
    $stdData=array();
    $stdData['student_id']=$row['student_id'];
    $stdData['semes']=$semester;

    $result=ac_result($row['student_id'],$row['group_id'],$semester);


    $stdData['act_value']=$result['percentage']>=$pass_score?'1':'0';

    array_push($data,$stdData);
}
print json_encode($data);



function ac_result($std_id,$group_id,$semester){
    global $systemDb;

    $semes=mb_substr($semester,0,1);
    $edu_year=mb_substr($semester,2,4);
    $acts=sSelectTb($systemDb,"activity",'*','semester='.sQ( $semes).' AND year='.sQ($edu_year).' AND group_id like "%'.$group_id.'%"');
    $count_ac=count($acts);

    $act_id=array();
foreach($acts as $row){
    array_push($act_id,$row['id']);
}

    foreach($act_id as $act_row){
        $check_data=sSelectTb($systemDb,"entry_record",'*','act_id='.$act_row.' AND student_id='.sQ($row['student_id']));
        $check_data=$check_data[0];
        if($check_data['entry_type']=='check'){
            $signAct++;
        }
    }

    return array(
        'total_act'=>$count_ac,
        'checked_act'=>$signAct,
        'percentage'=>$count_ac<1?'100':$signAct/$count_ac*100
    );

}
?>