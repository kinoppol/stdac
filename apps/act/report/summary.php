<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$act_id=$hGET['id'];
if(is_numeric($act_id)){
    $act_data=sSelectTb($systemDb,'activity','group_id','id='.sQ($act_id));
    $act_data=$act_data[0];


if($act_data['group_id']!=''){
    $groups_selected=json_decode($act_data['group_id'],true);
}else{
    $groups_selected=array();
}
}else{
    $groups_selected=array($hGET['gid']);

    

}

$group_data=sSelectTb($systemDb,'group','*');

$groups=array();
foreach($group_data as $grp){
    $groups[$grp['group_id']]=$grp;
}

foreach($groups_selected as $grp){
    $reports[]=array(
    'grp_id'=>$grp,
    'grp_name'=>$groups[$grp]['group_short_name'],
    'btn'=>'<a href="'.site_url('ajax/act/report/group/id/'.$act_id.'/grp_id/'.$grp).'" target="_blank" class="btn btn-danger"><i class="material-icons">book</i></a>'
);
}
$data=array("head"=>array(
    'รหัสกลุ่ม',
    'ชื่อกลุ่ม',
    'รายงาน',
    ),
    'id'=>'report_table',
    'item'=>$reports,
    'pagelength'=>10,
    'order'=>'[[ 2, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>
