<?php
load_fun('form');

$current_edu_year=date('m')<4?date('Y')+542:date('Y')+543;
            $current_semester=date('m')<10&&date('m')>4?1:2;
            $current_semester=$current_semester.'/'.$current_edu_year;

        if(get_system_config("current_semester")!=''){
            $current_semester=get_system_config("current_semester");

            
        }

            for($i=date('Y')+543+1;$i>=date('Y')+543-3;$i--){
                $semester_data['2/'.$i]='2/'.$i;
                $semester_data['1/'.$i]='1/'.$i;
            }


$inputDetail = array(
    'rms_url' => array(
        'label' => 'ที่อยู่ระบบ RMS (โปรดระบุ http://,https://)',
        'type' => 'text',
        'value'=>get_system_config("rms_url")
    ),
    'pass_score' => array(
        'label' => 'เกณฑ์ผ่านกิจกรรม (ต้องเข้าร่วมกิจกรรมร้อยละเท่าใดจึงจะผ่าน)',
        'type' => 'number',
        'value'=>get_system_config("pass_score")
    ),
    'current_semester' => array(
        'label' => 'ภาคเรียนปัจจุบัน',
        'type' => 'select',
        'item'=>$semester_data,
        'def'=>$current_semester
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
                <h2>ตั้งค่าระบบ</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
<?php
$saveURL=site_url('ajax/admin/config/save');
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