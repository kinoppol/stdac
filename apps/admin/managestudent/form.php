<div class="container-fluid">
<div id="ajaxResponse">
</div>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="card">
<div class="body">
<?php
load_fun('form');
$grpId=$hGET['id'];
if($grpId!=""){
    $ac_data=sSelectTb($systemDb,'group','*','group_id='.$grpId);
    $ac_data=$ac_data[0];
    $checker_data=sSelectTb($systemDb,'checker','*','group_id='.$grpId.' AND semester='.sQ(get_system_config('current_semester')));
    $checker_data=$checker_data[0];
    //print_r($checker_data);
    $saveURL=site_url('ajax/admin/managestudent/save_checker/id/'.$grpId);
}

$people_data=sSelectTb($systemDb,'userdata','*','1 order by people_id');
$checker_list=array();
foreach($people_data as $row){
    $checker_list[$row['people_id']]=$row['name'].' '.$row['surname'];
}
$m_ext='';
$a_ext='';

$morning_ceremony_checker_config=get_system_config("morning_ceremony_checker")!=''?get_system_config("morning_ceremony_checker"):'advisor';
$assembly_checker_config=get_system_config("assembly_checker")!=''?get_system_config("assembly_checker"):'advisor';

if($morning_ceremony_checker_config=='staff'){
$m_ext=' (ระบบมอบหมายให้งานกิจกรรมเป็นผู้เช็คชื่อ รายชื่อด้านล่างจะไม่มีผลใด ๆ)';
}elseif($morning_ceremony_checker_config=='advisor'){
$m_ext=' (ระบบมอบหมายให้ครูที่ปรึกษาเป็นผู้เช็คชื่อ รายชื่อด้านล่างจะไม่มีผลใด ๆ)';
}

if($assembly_checker_config=='staff'){
$a_ext=' (ระบบมอบหมายให้งานกิจกรรมเป็นผู้เช็คชื่อ รายชื่อด้านล่างจะไม่มีผลใด ๆ)';
}elseif($assembly_checker_config=='advisor'){
$a_ext=' (ระบบมอบหมายให้ครูที่ปรึกษาเป็นผู้เช็คชื่อ รายชื่อด้านล่างจะไม่มีผลใด ๆ)';
}

$dow_arr=array("0"=>'อาทิตย์',"1"=>'จันทร์','2'=>'อังคาร','3'=>'พุธ','4'=>'พฤหัสบดี','5'=>'ศุกร์','6'=>'เสาร์');
$dowa_arr=array(""=>'เลือกวัน',"0"=>'อาทิตย์',"1"=>'จันทร์','2'=>'อังคาร','3'=>'พุธ','4'=>'พฤหัสบดี','5'=>'ศุกร์','6'=>'เสาร์');
$inputDetail = array(
    'name' => array(
        'label' => 'ชื่อกลุ่ม',
        'type' => 'text',
        'placeholder' => 'ชื่อกลุ่ม',
        'icon' => 'settings_overscan',
        'value' => $ac_data['group_short_name'],
        'attr'=>array('disabled'),
    ),
    'group_id' => array(
        'type' => 'hidden',
        'value' => $ac_data['group_id'],
    ),
    'semester' => array(
        'label' => 'ภาคเรียน',
        'type' => 'text',
        'icon' => 'settings_overscan',
        'value' => get_system_config('current_semester'),
        'attr'=>array('readonly'),
    ),
    'morning_ceremony_checker' => array(
        'label' => 'ผู้เช็คชื่อกิจกรรมเข้าแถว'.$m_ext,
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => explode(',',$checker_data['morning_ceremony_checker']),
    ),
    'morning_ceremony_date' => array(
        'label' => 'วันที่เข้าแถว',
        'type' => 'select',
        //'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $dow_arr,
        'def' => explode(',',$checker_data['morning_ceremony_date']),
    ),
    'assembly_checker' => array(
        'label' => 'ผู้เช็คชื่อคาบกิจกรรม'.$a_ext,
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => explode(',',$checker_data['assembly_checker']),

    ),
    'assembly_date' => array(
        'label' => 'วันที่เข้าคาบกิจกรรม',
        'type' => 'select',
        'multiple'=>false,
        'icon' => 'settings_overscan',
        'item' => $dowa_arr,
        'def' => $checker_data['assembly_date']==''?-1:$checker_data['assembly_date'],
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'บันทึกข้อมูล'
    ),
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);


print gen_form(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));
?>
</div>
</div>
</div>
</div>
</div>