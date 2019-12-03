<div id="ajaxResponse">
</div>
<?php

load_fun('form');

    $saveURL=site_url('ajax/act/report/genPDF');


$inputDetail = array(
   
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
        'value' => 'สร้างรายงาน'
    ),
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);


print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'target' => '_blank',
    //'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));