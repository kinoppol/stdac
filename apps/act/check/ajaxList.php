<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
//print_r($_GET['p']);
$date=$hGET['date'];
if(!isset($date))$date=date('Y-m-d');
$table='entry_record';
//print $date;
$act_id=$hGET['id'];
if($act_id=='assembly')$table.='_as';
if($act_id=='morningCeremony')$table.='_mc';

if($hGET['id']=='morningCeremony'||$hGET['id']=='assembly'){
    $groups_selected=array($hGET['gid']);
}else{
    $act_id=$hGET['id'];
    $act_data=sSelectTb($systemDb,'activity','group_id','id='.sQ($act_id));
    $act_data=$act_data[0];


    if($act_data['group_id']!=''){
        $groups_selected=json_decode($act_data['group_id']);
    }else{
        $groups_selected=array();
    }
}
$prefix=array(
    '1'=>'นางสาว',
    '2'=>'นาย',
    '3'=>'เด็กชาย',
    '4'=>'เด็กหญิง',
    '5'=>'นาง',

);
$student_data=sSelectTb($systemDb,'std','*','group_id in ('.implode(',',$groups_selected).') order by student_id asc');

$student_ids=array();

foreach($student_data as $row){
    $student_ids[]=$row['student_id'];
}
$group_data=sSelectTb($systemDb,'group','*');

$groups=array();
foreach($group_data as $grp){
    $groups[$grp['group_id']]=$grp;
}

$students=array();
if(is_numeric($act_id)){
    $cond='act_id='.sQ($act_id);
}else{
    $cond='date_check='.sQ($date).' AND student_id in ('.implode(',',$student_ids).')';
}
$check_record=sSelectTb($systemDb,$table,'*',$cond);
$record=array();
foreach($check_record as $rec){
    $record[$rec['student_id']]=$rec['entry_type'];
}
//print_r($record);
$std_no=0;
foreach($student_data as $std){
    $std_no++;
    $param_date='';
    if($date){
        $param_date=',\''.$date.'\'';
        print $param;
    }

    if($record[$std['student_id']]=='check'){

        $chk_box='
        <div id="chk_'.$std['student_id'].'" class="chk_btn">
            <a href="#"
                onClick="optionCheck_std('.$std['student_id'].$param_date.')"><i class="material-icons col-green">check_box</i></a>
            </a>
        </div>';
    }else if($record[$std['student_id']]=='late'){

        $chk_box='
        <div id="chk_'.$std['student_id'].'" class="chk_btn">
            <a href="#"
                onClick="optionCheck_std('.$std['student_id'].$param_date.')" title="สาย"><i class="material-icons col-orange">access_time</i></a>
            </a>
        </div>';
    }else{
    $chk_box='
    <div id="chk_'.$std['student_id'].'" class="chk_btn">
        <a href="#"
            onClick="check_std('.$std['student_id'].$param_date.')"><i class="material-icons col-black">check_box_outline_blank</i></a>
        </a>
    </div>';
    }

    $students[$std['student_id']]=array(
        'std_no'=>$std_no,
        'student_id'=>$std['student_id'],
        'name'=>$prefix[$std['prefix_id']].$std['stu_fname'].' '.$std['stu_lname'],
        'check_box'=>$chk_box,
    );

}

$data=array("head"=>array(
    'เลขที่',
    'รหัสนักศึกษา',
    'ชื่อ-สกุล',
    'เช็คชื่อ'
    ),
    'id'=>'std_table',
    'item'=> $students,
    'pagelength'=>10,
    'order'=>'[[ 0, "asc" ]]'
    );
    print datatable($data);
    ?>
    </div>