<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
$current_semester=get_system_config("current_semester");
$current_edu_year=mb_substr($current_semester,2,4);
$current_semester=mb_substr($current_semester,0,1);

$ac_data=sSelectTb($systemDb,"activity",'*','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' order by start_time desc');
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
    

    if(current_user('user_type')=='admin'||current_user('user_type')=='staff'){
        $edit_ac_link='<a '.gen_modal_link($group_btn).' class="btn btn-info" title="เลือกกลุ่มผู้เรียน"><i class="material-icons">group_add</i></a> '.
        '<a '.gen_modal_link($edit_btn).' class="btn btn-warning" title="แก้ไข"><i class="material-icons">build</i></a> ';
    }

$ac_row=array(
    'no'=>$i,
    'name'=>'<span title="'.strlim($row['name']).'">'.strlim($row['name'],50).'</span>',
    'start_time'=>mb_substr($row['start_time'],0,10).'<br>เวลา '.mb_substr($row['start_time'],11,5).' น.',
    'end_time'=>mb_substr($row['end_time'],0,10).'<br>เวลา '.mb_substr($row['end_time'],11,5).' น.',
    'semester'=>$row['semester'].'/'.$row['year'],
    '<a '.gen_modal_link($scan_btn).' class="btn btn-success" title="สแกนบัตร"><i class="material-icons">camera</i></a> '.
    '<a '.gen_modal_link($check_btn).' class="btn btn-primary" title="เช็คชื่อ"><i class="material-icons">check_circle</i></a> '.
    '<a '.gen_modal_link($report_btn).' class="btn btn-danger" title="รายงานการเช็คชื่อ"><i class="material-icons">book</i></a> '.
    $edit_ac_link,
    'del'=>'<a href="'.site_url('main/act/view/list/action/delete/id/'.$row['id']).'" onClick="return confirm(\'ลบ?\')"><i class="material-icons col-red">delete</i></a>'
);

if(current_user('user_type')!='admin'&&current_user('user_type')!='staff'){
    unset($ac_row['del']);
    unset($ac_row['select_group']);
}

    $table_data[]=$ac_row;
    
}

$head_arr=array(
    'ที่',
    'ชื่อกิจกรรม',
    'เริ่ม',
    'สิ้นสุด',
    'ภาคเรียน',
    '<center>จัดการ</center>',
    'del'=>'ลบ',
);

if(current_user('user_type')!='admin'&&current_user('user_type')!='staff'){
    unset($head_arr['del']);
}

$data=array("head"=>$head_arr,
    'id'=>'activity_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 2, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>