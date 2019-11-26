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


    $edit_btn=array(
        'id'=>'editAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/add_ac/form/id/'.$row['id']),
    );

    $scan_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_scaner/id/'.$row['id']),
    );

    $check_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_manual/id/'.$row['id']),
    );

    $report_btn=array(
        'id'=>'reportAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/report/summary/id/'.$row['id']),
    );
    
    $group_btn=array(
        'id'=>'groupAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/group/manage/id/'.$row['id']),
    );
    

    $table_data[]=array(
        'no'=>$i,
        'name'=>$row['name'],
        'start_time'=>$row['start_time'],
        'end_time'=>$row['end_time'],
        'semester'=>$row['semester'].'/'.$row['year'],
        '<a '.gen_modal_link($scan_btn).' class="btn btn-success" title="สแกนบัตร"><i class="material-icons">camera</i></a> '.
        '<a '.gen_modal_link($check_btn).' class="btn btn-primary" title="เช็คชื่อ"><i class="material-icons">check_circle</i></a> '.
        '<a '.gen_modal_link($report_btn).' class="btn btn-danger" title="รายงานการเช็คชื่อ"><i class="material-icons">book</i></a> '.
        '<a '.gen_modal_link($group_btn).' class="btn btn-info" title="เลือกกลุ่มผู้เรียน"><i class="material-icons">group_add</i></a> '.
        '<a '.gen_modal_link($edit_btn).' class="btn btn-warning" title="แก้ไข"><i class="material-icons">build</i></a> ',
        '<a href="'.site_url('main/act/view/list/action/delete/id/'.$row['id']).'" onClick="return confirm(\'ลบ?\')"><i class="material-icons col-red">delete</i></a>'
    );
    
}
$data=array("head"=>array(
    'ที่',
    'ชื่อกิจกรรม',
    'เริ่ม',
    'สิ้นสุด',
    'ภาคเรียน',
    '<center>จัดการ</center>',
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