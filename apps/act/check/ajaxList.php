<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
//print_r($_GET['p']);
if($hGET['id']=='morningCeremony'){
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
$student_data=sSelectTb($systemDb,'std','*','group_id in ('.implode(',',$groups_selected).')');

$group_data=sSelectTb($systemDb,'group','*');

$groups=array();
foreach($group_data as $grp){
    $groups[$grp['group_id']]=$grp;
}

$students=array();

$cond='act_id='.sQ($act_id);
$check_record=sSelectTb($systemDb,'entry_record','*',$cond);
$record=array();
foreach($check_record as $rec){
    $record[$rec['student_id']]=$rec['entry_type'];
}
//print_r($record);
foreach($student_data as $std){

    

    if($record[$std['student_id']]=='check'){

        $chk_box='
        <div id="chk_'.$std['student_id'].'" class="chk_btn">
            <a href="#"
                onClick="unCheck_std('.$std['student_id'].')"><i class="material-icons col-green">check_box</i></a>
            </a>
        </div>';
    }else{
    $chk_box='
    <div id="chk_'.$std['student_id'].'" class="chk_btn">
        <a href="#"
            onClick="check_std('.$std['student_id'].')"><i class="material-icons col-black">check_box_outline_blank</i></a>
        </a>
    </div>';
    }

    $students[$std['student_id']]=array(
        'group_id'=>$groups[$std['group_id']]['group_short_name'],
        'student_id'=>$std['student_id'],
        'name'=>$prefix[$std['prefix_id']].$std['stu_fname'].' '.$std['stu_lname'],
        'check_box'=>$chk_box,
    );

}

$data=array("head"=>array(
    'กลุ่ม',
    'รหัสนักศึกษา',
    'ชื่อ-สกุล',
    'เช็คชื่อ'
    ),
    'id'=>'std_table',
    'item'=> $students,
    'pagelength'=>10,
    'order'=>'[[ 0, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>