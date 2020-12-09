<div id="ajaxResponse">
</div>
<div class="card">
<?php
load_fun('form');
$acId=$hGET['id'];
if($acId!=""){
    $ac_data=sSelectTb($systemDb,'activity','*','id='.$acId);
    $ac_data=$ac_data[0];
    $saveURL=site_url('ajax/act/add_ac/add_list_ac/id/'.$acId);
}else{
    $saveURL=site_url('ajax/act/add_ac/add_list_ac');
}

$inputDetail = array(
    'name' => array(
        'label' => 'ชื่อกิจกรรม',
        'type' => 'text',
        'placeholder' => 'ระบุชื่อกิจกรรม',
        'icon' => 'settings_overscan',
        'value' => $ac_data['name']
    ),
    'start_day' => array(
        'label' => 'วันเริ่มกิจกรรม',
        'type' => 'date',
        'icon' => 'settings_overscan',
        'value' => $ac_data['start_time']?mb_substr($ac_data['start_time'],0,10):date('Y-m-d')
    ),
    'start_time' => array(
        'label' => 'เวลา',
        'type' => 'time',
        'icon' => 'settings_overscan',
        'value' => mb_substr($ac_data['start_time'],11,5)
    ),
    'end_day' => array(
        'label' => 'วันสิ้นสุดกิจกรรม',
        'type' => 'date',
        'icon' => 'settings_overscan',
        'value' => $ac_data['end_time']?mb_substr($ac_data['end_time'],0,10):date('Y-m-d')
    ),
    'end_time' => array(
        'label' => 'เวลา',
        'type' => 'time',
        'icon' => 'settings_overscan',
        'value' => mb_substr($ac_data['end_time'],11,5)
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
    'semester' => array(
        'label' => 'ภาคเรียน',
        'type' => 'select',
        'item' => array(
            1=>'1',2=>'2',3=>'3',4=>'4'
        ),
        'def'=>$ac_data['semester']
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
?>
</div>