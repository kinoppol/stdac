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
    'tab1'=>array(
    "id"=>"activityTab",
    "label"=>"เกณฑ์การประเมินผล",
    "type"=>"tab-pane",
    "class"=>"active"
    ),
    'pass_score_activity' => array(
        'label' => 'เกณ์การผ่านกิจกรรม(ร่วมกิจกรรมบังคับ)',
        'type' => 'number',
        'value'=>get_system_config("pass_score_activity")!=''?get_system_config("pass_score_activity"):60,
    ),
    'pass_score_morning_ceremony' => array(
            'label' => 'เกณ์การผ่านกิจกรรมหน้าเสาธง',
            'type' => 'number',
            'value'=>get_system_config("pass_score_morning_ceremony")!=''?get_system_config("pass_score_morning_ceremony"):60,
    ),
        'pass_score_assembly' => array(
        'label' => 'เกณ์การผ่านคาบกิจกรรม',
        'type' => 'number',
        'value'=>get_system_config("pass_score_assembly")!=''?get_system_config("pass_score_assembly"):60,
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
                <h2>ตั้งค่าการประเมินผล (ร้อยละที่จะผ่านเกณฑ์การเข้าร่วมกิจกรรมแต่ละรายการ)</h2>
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