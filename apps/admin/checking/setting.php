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
        "label"=>"กิจกรรมกลาง",
        "type"=>"tab-pane",
        "class"=>"active"
        ),
    'activity_early_signin' => array(
        'label' => 'สแกนบัตรเข้าร่วมกิจกรรมก่อนถึงเวลาที่กำหนด(นาที)',
        'type' => 'number',
        'value'=>get_system_config("activity_early_signin")!=''?get_system_config("activity_early_signin"):0,
    ),
    'activity_late_signin' => array(
            'label' => 'สแกนบัตรเข้าร่วมกิจกรรมสายเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("activity_late_signin")!=''?get_system_config("activity_late_signin"):15,
    ),
    'activity_late_score' => array(
            'label' => 'ร้อยละของการเข้าร่วมกิจกรรมในกรณีเข้าร่วมฯ สาย (เมื่อเข้าร่วมฯ ปกติคือร้อยละ 100)',
            'type' => 'number',
            'value'=>get_system_config("activity_late_score")!=''?get_system_config("activity_late_score"):50,
    ),
    'activity_absent_signin' => array(
            'label' => 'ถือว่าขาดการเข้าร่วมกิจกรรมเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("activity_absent_signin")!=''?get_system_config("activitactivity_absent_signiny_late_signin"):30,
    )
    
);

if(get_system_config("active_morning_ceremony")=='active'){
    
    $inputDetail['tab2']=array(
            "id"=>"morningCeremonyTab",
            "label"=>"กิจกรรมหน้าเสาธง",
            "type"=>"tab-pane",
            "class"=>""
            );
    $inputDetail['morning_ceremony_early_signin'] = array(
        'label' => 'สแกนบัตรเข้าแถวก่อนถึงเวลาที่กำหนด(นาที)',
        'type' => 'number',
        'value'=>get_system_config("morning_ceremony_early_signin")!=''?get_system_config("morning_ceremony_early_signin"):5,
    );
    $inputDetail['morning_ceremony_late_signin'] = array(
            'label' => 'สแกนบัตรเข้าแถวสายเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("morning_ceremony_late_signin")!=''?get_system_config("morning_ceremony_late_signin"):10,
    );
    $inputDetail['morning_ceremony_late_score'] = array(
            'label' => 'ร้อยละของการเข้าแถวในกรณีเข้าแถวสาย (เมื่อเข้าแถวปกติคือร้อยละ 100)',
            'type' => 'number',
            'value'=>get_system_config("morning_ceremony_late_score")!=''?get_system_config("morning_ceremony_late_score"):66,
    );
    $inputDetail['morning_ceremony_absent_signin'] = array(
            'label' => 'ถือว่าขาดแถวเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("morning_ceremony_absent_signin")!=''?get_system_config("activitmorning_ceremony_absent_signiny_late_signin"):15,
    );
}

if(get_system_config("active_assembly")=='active'){
    $inputDetail['tab3']=array(
        "id"=>"assemblyTab",
        "label"=>"คาบกิจกรรม",
        "type"=>"tab-pane",
        "class"=>""
    );
    $inputDetail['assembly_early_signin'] = array(
        'label' => 'สแกนบัตรเข้าคาบกิจจกรมได้ก่อนถึงเวลาที่กำหนด(นาที)',
        'type' => 'number',
        'value'=>get_system_config("assembly_early_signin")!=''?get_system_config("assembly_early_signin"):0,
    );
    $inputDetail['assembly_late_signin'] = array(
            'label' => 'สแกนบัตรเข้าคาบกิจกรรมสายเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("assembly_late_signin")!=''?get_system_config("assembly_late_signin"):15,
    );
    $inputDetail['assembly_late_score']=array(
            'label' => 'ร้อยละของการเข้าร่วมคาบกิจกรรมในกรณีเข้าร่วมฯ สาย (เมื่อเข้าร่วมฯ ปกติคือร้อยละ 100)',
            'type' => 'number',
            'value'=>get_system_config("assembly_late_score")!=''?get_system_config("assembly_late_score"):80,
    );
    $inputDetail['assembly_absent_signin'] = array(
            'label' => 'ถือว่าขาดคาบกิจกรรมเมื่อเลยเวลาที่กำหนดไปแล้ว(นาที)',
            'type' => 'number',
            'value'=>get_system_config("assembly_absent_signin")!=''?get_system_config("activitassembly_absent_signiny_late_signin"):30,
    );
}

$inputDetail['closeTab']=array(
                            "type"=>"close-tab-pane",
                        );
$inputDetail['submit']=array(
                            'label' => '&nbsp;',
                            'type' => 'submit',
                            'value' => 'บันทึก'
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
                <h2>ตั้งค่าการเช็คชื่อเข้าร่วมกิจกรรม</h2>
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