<?php
load_fun('form');

$inputDetail = array(
    'doc_code' => array(
        'label' => 'ชื่อ',
        'type' => 'text',
        'placeholder' => 'ว่างไว้เพื่อกำหนดโดยอัตโนมัติ',
        'icon' => 'fa fa-sort-amount-desc',
        'value' => $docData['doc_code']
    ),
    'doc_title' => array(
        'label' => 'นามสกุล',
        'type' => 'text',
        'placeholder' => 'ว่างไว้เพื่อกำหนดโดยอัตโนมัติ',
        'icon' => 'fa fa-header',
        'value' => $docData['doc_title']
    ),
    'note' => array(
        'label' => 'Email',
        'type' => 'textarea',
        'icon' => 'fa fa-warning',
        'value' => $docData['note']
    ),
    'doc_from' => array(
        'label' => 'เบอร์โทรศัพท์',
        'type' => 'text',
        'icon' => 'fa fa-user',
        'value' => $docData['doc_from']
    ),
    'endorser' => array(
        'label' => 'ผู้ลงนาม',
        'type' => 'text',
        'icon' => 'fa fa-user-secret',
        'value' => $docData['endorser']
    ),
    'date_sign' => array(
        'label' => 'ลงนามวันที่',
        'type' => 'date',
        'icon' => 'fa fa-calendar',
        'value' => $docData['date_sign'] ? $docData['date_sign'] : date('Y-m-d')
    ),
    'doc_year' => array(
        'label' => 'ปี',
        'type' => 'select',
        'icon' => 'fa fa-angle-double-down',
        'item' => array(
            date('Y') => date('Y') + 543,
            date('Y') - 1 => date('Y') + 542
        ),
        'def' => $docData['doc_year'] ? $docData['doc_year'] : date('Y')
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'บันทึก'
    )
);
$onSubmit .= '
alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);
?>
<div class="container">
<div id="ajaxResponse">
</div>
<div class="container-fluid">
            <div class="block-header">
                <h2>ข้อมูลส่วนตัว</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
<?php
$saveURL=site_url('ajax/user/profile/save');
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
</div>
</div>
</div>
</div>