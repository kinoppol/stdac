<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$ac_data=sSelectTb($systemDb,"activity",'*','1 order by start_time desc');
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $table_data[]=array(
        'student_id'=>$i,
        'prefix_id'=>$row['name'],
        'start_time'=>$row['start_time'],
        'end_time'=>$row['end_time'],
        'semester'=>$row['semester'],
        'year'=>$row['year'],
        '<a href="'.site_url('main/act/transfer/student/action/delete/id/'.$row['id']).'" onClick="return confirm(\'ลบ?\')"><i class="material-icons col-red">delete</i></a>'
    );
    
}
$data=array("head"=>array(
    'ที่',
    'ชื่อกิจกรรม',
    'เริ่ม',
    'สิ้นสุด',
    'ภาคเรียน',
    'ปีการศึกษา',
    'ลบ',
    ),
    'id'=>'activity_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 2, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>