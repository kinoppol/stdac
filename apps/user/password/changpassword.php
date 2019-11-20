<?php
load_fun('form');

$inputDetail = array(
    'password' => array(
        'label' => 'รหัสผ่าน',
        'type' => 'password',
        //'placeholder' => 'ว่างไว้เพื่อกำหนดโดยอัตโนมัติ',
        'icon' => 'fa fa-sort-amount-desc',
        //'value' => $docData['doc_code']
    ),
    'confirmpassword' => array(
        'label' => 'ยืนยันรหัสผ่าน',
        'type' => 'password',
        //'placeholder' => 'ว่างไว้เพื่อกำหนดโดยอัตโนมัติ',
        'icon' => 'fa fa-header',
        //'value' => $docData['doc_title']
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'บันทึก'
    )
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);
?>
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
$saveURL=site_url('ajax/user/password/save');
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