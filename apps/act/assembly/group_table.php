<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$current_semester=get_system_config("current_semester");


$group_isCheckable=sSelectTb($systemDb,"checker",'*','assembly_checker like '.sQ('%'.current_user('people_id').'%').' AND semester ='.sQ($current_semester));
$groups='';
foreach($group_isCheckable as $row){
    if($groups!='')$groups.=',';
    $groups.=sQ($row['group_id']);
}

$ac_data=sSelectTb($systemDb,"group",'*','group_id in ('.$groups.')');
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $scan_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_scaner/mode/assembly/gid/'.$row['group_id']),
    );

    $check_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_manual/mode/assembly/gid/'.$row['group_id']),
    );

    $report_btn=array(
        'id'=>'reportAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/report/summary/mode/assembly/gid/'.$row['group_id']),
    );

    $table_data[]=array(
        //'no'=>$i,
        'group_id'=>$row['group_id'],
        'group_short_name'=>$row['group_short_name'],
        'major_name'=>$row['major_name'],
        'minor_name'=>$row['minor_name'],
        'level_name'=>$row['level_name'],
        '<a '.gen_modal_link($scan_btn).' class="btn btn-success" title="สแกนบัตร"><i class="material-icons">camera</i></a> '.
        '<a '.gen_modal_link($check_btn).' class="btn btn-primary" title="เช็คชื่อ"><i class="material-icons">check_circle</i></a> '.
        '<a '.gen_modal_link($report_btn).' class="btn btn-danger" title="รายงานการเช็คชื่อ"><i class="material-icons">book</i></a> '
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'รหัสกลุ่ม',
    'ชื่อกลุ่ม',
    'สาขาวิชา',
    'สาขางาน',
    'ชั้นปี',
    'จัดการ',
    ),
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>