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
        'major_name'=>strLim($row['major_name'],20),
        'minor_name'=>strLim($row['minor_name'],20),
        //'level_name'=>$row['level_name'],
        '<a '.gen_modal_link($report_btn).' class="btn btn-primary" title="รายงานการเช็คชื่อ"><i class="material-icons">book</i></a> ',
        '<a href="'.site_url('main/act/sum/viewGroup/group_id/'.$row['group_id']).'" class="btn btn-danger"><i class="material-icons" title="สรุปผล">assignment</i></a>'
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'รหัสกลุ่ม',
    'ชื่อกลุ่ม',
    'สาขาวิชา',
    'สาขางาน',
    //'ชั้นปี',
    'สรุปกิจกรรม<br>หน้าเสาธง',
    'สรุปรวม',
    ),
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>