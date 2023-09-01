<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$act_id=$hGET['id'];
$act_data=sSelectTb($systemDb,'activity','group_id','id='.sQ($act_id));
$act_data=$act_data[0];

if($act_data['group_id']!=''){
    $groups_selected=json_decode($act_data['group_id'],true);
}else{
    $groups_selected=array();
}

//print_r($groups_selected);

$group_data=sSelectTb($systemDb,'group','group_id,group_short_name,level_name','1 order by group_id desc');
$groups=array();
foreach($group_data as $group){
    
    if (array_search($group['group_id'], $groups_selected) !== false) {
        $chk_box='
        <div id="chk_'.$group['group_id'].'" class="chk_btn">
        <a href="#"
         onClick="del_group('.$group['group_id'].')"><i class="material-icons col-green">check_box</i></a>
        </a>';
    }else{
        $chk_box='
        <div id="chk_'.$group['group_id'].'" class="chk_btn">
        <a href="#"
         onClick="add_group('.$group['group_id'].')"><i class="material-icons col-black">check_box_outline_blank</i></a>
        </a>';
    }

    $groups[]=array(
        $group['group_id'],
        $group['level_name'],
        $group['group_short_name'],
        $chk_box
    );
}

$data=array("head"=>array(
    'รหัสกลุ่ม',
    'ระดับชั้น',
    'ชื่อกลุ่ม',
    'เลือก'
    ),
    'id'=>'group_table',
    'item'=>$groups,
    'pagelength'=>10,
    'order'=>'[[ 0, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>