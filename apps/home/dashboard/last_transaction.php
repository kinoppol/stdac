<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$ac_data=sSelectTb($systemDb,"activity",'*');
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $table_data[]=array(
        'no'=>$i,
        'name'=>$row['name'],
        'start_time'=>$row['start_time'],
        'end_time'=>$row['end_time'],
    );
    
}
$data=array("head"=>array(
    'ที่',
    'ชื่อกิจกรรม',
    'เริ่ม',
    'สิ้นสุด'
    ),
    'id'=>'activity_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>