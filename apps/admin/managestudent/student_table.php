<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$group_id=$hGET['group'];

$ac_data=sSelectTb($systemDb,"std",'*','group_id='.$group_id);
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $table_data[]=array(
        //'no'=>$i,
        'student_id'=>$row['student_id'],
        'stu_fname'=>$row['stu_fname'],
        'stu_lname'=>$row['stu_lname'],
        //'group_id'=>$row['group_id'],
        //'level_name'=>$row['level_name'],
        //'major_name'=>$row['major_name'],
        //'<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'"><i class="material-icons col-red">search</i></a>'
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'รหัสนักเรียน',
    'ชื่อ',
    'สกุล',
    //'รหัสกลุ่ม',
    //'ระดับชั้น',
    //'ชื่อกลุ่ม',
    ),
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>