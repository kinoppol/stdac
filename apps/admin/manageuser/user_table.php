<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$group_id=$hGET['group'];

$ac_data=sSelectTb($systemDb,"userdata",'*');
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $table_data[]=array(
        //'no'=>$i,
        'people_id'=>$row['people_id'],
        'firstname'=>$row['name'],
        'lastname'=>$row['surname'],
        'user_type'=>$row['user_type'],
        '<a href="token.php?id='.$row['people_id'].'&token='.md5($row['people_id'].date('Y-m-d')).'"><i class="material-icons">extension</i></a>',
        //'group_id'=>$row['group_id'],
        //'level_name'=>$row['level_name'],
        //'major_name'=>$row['major_name'],
        //'<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'"><i class="material-icons col-red">search</i></a>'
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'เลขประจำตัวประชาชน',
    'ชื่อ',
    'สกุล',
    'ประเภท',
    'สวมสิทธิ์',
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