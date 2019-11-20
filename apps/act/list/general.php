<?php
load_fun('form');

$inputDetail = array(
    'qr' => array(
        'label' => 'สแกนบัตร',
        'type' => 'text',
        'placeholder' => 'สแกนบัตรเพื่อลงทะเบียน',
        'icon' => 'settings_overscan',
        //'value' => $docData['doc_code']
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'ลงทะเบียน'
    )
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);
?>
<div class="container-fluid">
            <div class="block-header">
                <h2>สแกนบัตรลงทะเบียนกิจกรรม</h2>
            </div>


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                        <div id="ajaxResponse">
                        </div>
<?php
$saveURL=site_url('ajax/register/record/save');
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
