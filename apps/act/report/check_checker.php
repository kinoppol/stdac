<div class="container-fluid">
<div id="ajaxResponse">
</div>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="card">
<div class="body">
    <?php
$inputDetail = array(
    'semester' => array(
        'label' => 'ภาคเรียน',
        'type' => 'text',
        'icon' => 'settings_overscan',
        'value' => get_system_config('current_semester'),
        'attr'=>array('readonly'),
    ),
    's_date' => array(
        'label' => 'วันที่เริ่มต้นรายงาน',
        'type' => 'date',
        'icon' => 'settings_overscan',
        'value' => date('Y-m-d')
    ),
    'e_date' => array(
        'label' => 'วันที่สิ้นสุดรายงาน',
        'type' => 'date',
        'icon' => 'settings_overscan',
        'value' => date('Y-m-d')
    ),
    'marker' => array(
        'label' => 'เครื่องหมาย',
        'type' => 'select',
        'icon' => 'settings_overscan',
        'item' => array('check'=>'เครื่องหมายถูก ✔','number'=>'เลข 1'),
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'ตกลง'
    ),
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);

$saveURL=site_url('ajax/act/report/checker');

print gen_form(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    //'ajaxSubmit' => $inputDetail,
    //'response' => 'ajaxResponse',
    //'onSubmit' => $onSubmit,
    'item' => $inputForm
));
?>
</div>
</div>
</div>
</div>
</div>