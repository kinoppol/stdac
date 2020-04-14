<div id="ajaxResponse">
</div>
<?php
load_fun('form');
$grpId=$hGET['id'];
if($grpId!=""){
    $ac_data=sSelectTb($systemDb,'group','*','group_id='.$grpId);
    $ac_data=$ac_data[0];
    $saveURL=site_url('ajax/admin/managestudent/save_group/id/'.$grpId);
}

$people_data=sSelectTb($systemDb,'userdata','*','user_type!='.sQ('admin'));
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
    'morning_ceremony_checker' => array(
        'label' => 'ผู้เช็คชื่อกิจกรรมเข้าแถว',
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => $ac_data['group_short_name'],
    ),
    'assembly_checker' => array(
        'label' => 'ผู้เช็คชื่อคาบกิจกรรม',
        'type' => 'select',
        'tokenize'=>true,
        'multiple'=>true,
        'icon' => 'settings_overscan',
        'item' => $checker_list,
        'def' => $ac_data['group_short_name'],

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


print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));