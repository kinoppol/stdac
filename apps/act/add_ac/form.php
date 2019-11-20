<div id="ajaxResponse">
</div>
<?php

load_fun('form');

$inputDetail = array(
    'name' => array(
        'label' => 'ชื่อกิจกรรม',
        'type' => 'text',
        'placeholder' => 'ระบุชื่อกิจกรรม',
        'icon' => 'settings_overscan',
        //'value' => $docData['doc_code']
    ),
    'start_day' => array(
        'label' => 'วันเริ่มกิจกรรม',
        'type' => 'date',
        'icon' => 'settings_overscan',
    ),
    'start_time' => array(
        'label' => 'เวลา',
        'type' => 'time',
        'icon' => 'settings_overscan',
    ),
    'end_day' => array(
        'label' => 'วันสิ้นสุดกิจกรรม',
        'type' => 'date',
        'icon' => 'settings_overscan',
    ),
    'end_time' => array(
        'label' => 'เวลา',
        'type' => 'time',
        'icon' => 'settings_overscan',
    ),
    
    'semester' => array(
        'label' => 'ภาคเรียน',
        'type' => 'select',
        'item' => array(
            1=>'1',2=>'2',3=>'3',4=>'4'
        ),
    ),
    'year' => array(
        'label' => 'ปีการศึกษา',
        'type' => 'select',
        'item' => array(
            date('Y')+544=>date('Y')+544,
            date('Y')+543=>date('Y')+543,
            date('Y')+542=>date('Y')+542,
        ),
        'def'=>date('Y')+543,
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

$saveURL=site_url('ajax/act/add_ac/add_list_ac');
print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));