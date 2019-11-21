<div id="ajaxResponse">
</div>
<?php

load_fun('form');
$acId=$hGET['id'];

    $ac_data=sSelectTb($systemDb,'activity','*','id='.$acId);
    $ac_data=$ac_data[0];
    $saveURL=site_url('ajax/act/check/entry_save/id/'.$acId);


$inputDetail = array(
    'student_id' => array(
        'label' => 'รหัสประจำตัวนักศึกษา',
        'type' => 'text',
        'placeholder' => 'ระบุรหัสประจำตัวนักศึกษา',
        'icon' => 'settings_overscan',
        'value' => ''
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

$systemFoot.='
<script> 
$(function() {
    setInterval(focus_std,1000);
    
});
function focus_std(){
    $( "#student_id" ).focus();
}
</script>
';

print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));