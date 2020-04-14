<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$ac_data=sSelectTb($systemDb,"group",'*');
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $edit_btn=array(
        'id'=>'editStdGrp',
        'onlyClickClose'=>false,
        'src'=>site_url('ajax/admin/managestudent/form/id/'.$row['group_id']),
    );
    $table_data[]=array(
        //'no'=>$i,
        'group_id'=>$row['group_id'],
        'group_short_name'=>$row['group_short_name'],
        'major_name'=>$row['major_name'],
        'minor_name'=>$row['minor_name'],
        'level_name'=>$row['level_name'],
        '<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'" class="btn btn-info"><i class="material-icons">search</i></a> '.
        '<a '.gen_modal_link($edit_btn).' class="btn btn-warning" title="แก้ไข"><i class="material-icons">build</i></a>'
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