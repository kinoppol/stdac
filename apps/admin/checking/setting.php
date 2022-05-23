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
            'value'=>get_system_config("activity_absent_signin")!=''?get_system_config("activity_absent_signin"):30,
    ),
    'activity_after_check' => array(
            'label' => 'เช็คชื่อย้อนหลังได้กี่วัน(กรณีเช็คด้วยมือ)',
            'type' => 'number',
            'value'=>get_system_config("activity_after_check")!=''?get_system_config("activity_after_check"):7,
    )
    
);
