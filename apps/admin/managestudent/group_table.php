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
    $table_data[]=array(
        //'no'=>$i,
        'group_id'=>$row['group_id'],
        'group_short_name'=>$row['group_short_name'],
        'major_name'=>$row['major_name'],
        'minor_name'=>$row['minor_name'],
        'level_name'=>$row['level_name'],
        '<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'"><i class="material-icons col-red">search</i></a>'
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