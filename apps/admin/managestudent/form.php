<div id="ajaxResponse">
</div>
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
        'label' => 'ผู้เช็คชื่อกิจกรรมเข้าแถว',
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => explode(',',$checker_data['morning_ceremony_checker']),
    ),
    'assembly_checker' => array(
        'label' => 'ผู้เช็คชื่อคาบกิจกรรม',
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => explode(',',$checker_data['assembly_checker']),

    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'บันทึกกิจกรรม'
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