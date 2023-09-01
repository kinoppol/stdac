<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
$group_isCheckable=sSelectTb($systemDb,"checker",'*','morning_ceremony_checker like '.sQ('%'.current_user('people_id').'%').' AND semester = '.sQ(get_system_config('current_semester')));
$groups='';
foreach($group_isCheckable as $row){
    if($groups!='')$groups.=',';
    $groups.=sQ($row['group_id']);
}

$ac_data=sSelectTb($systemDb,"group",'*','group_id in ('.$groups.')');
//print_r($ac_data);

$table_data=array();
$i=0;
foreach($ac_data as $row){
    $i++;
    $scan_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_scaner/id/morningCeremony/gid/'.$row['group_id']),
    );

    $check_btn=array(
        'id'=>'checkAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/check/form_manual/id/morningCeremony/gid/'.$row['group_id']),
    );

    $report_btn=array(
        'id'=>'reportAc',
        'onlyClickClose'=>true,
        'src'=>site_url('ajax/act/report/summary/id/morningCeremony/gid/'.$row['group_id']),
    );

    $scan_link=gen_modal_link($scan_btn);
    $scan_color='success';
    $manual_link=gen_modal_link($check_btn);
    $manual_color='primary';
    if(get_system_config("morning_ceremony_force_checking")=='force_in_time'){
        $start_time=strtotime(get_system_config("morning_ceremony_start_time"));
        $end_time=strtotime(get_system_config("morning_ceremony_end_time"));
        $current_time=strtotime(date('H:i'));
        if($current_time<$start_time||$current_time>$end_time){
            $scan_link=' href="javascript:alert(\'อนุญาตให้เช็คชื่อในเวลา '.get_system_config("morning_ceremony_start_time").' - '.get_system_config("morning_ceremony_end_time").' เท่านั้น\\n(หากถึงเวลาแล้วยังเช็คชื่อไมได้ให้รีเฟรช)\')"';
            $scan_color='default';
            $manual_link=$scan_link;
            $manual_color='default';
        }
        /*
        print $start_time.'<br>';
        print $end_time.'<br>';
        print $current_time.'<br>';
        */
    }
    $table_data[]=array(
        //'no'=>$i,
        'group_id'=>$row['group_id'],
        'group_short_name'=>$row['group_short_name'],
        'major_name'=>$row['major_name'],
        //'minor_name'=>$row['minor_name'],
        //'level_name'=>$row['level_name'],
        '<a '.$scan_link.' class="btn btn-'.$scan_color.'" title="สแกนบัตร"><i class="material-icons">camera</i></a> '.
        '<a '.$manual_link.' class="btn btn-'.$manual_color.'" title="เช็คชื่อ"><i class="material-icons">check_circle</i></a> '.
        '<a '.gen_modal_link($report_btn).' class="btn btn-danger" title="รายงานการเช็คชื่อ"><i class="material-icons">book</i></a> '
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'รหัสกลุ่ม',
    'ชื่อกลุ่ม',
    'สาขาวิชา',
    //'สาขางาน',
    //'ชั้นปี',
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