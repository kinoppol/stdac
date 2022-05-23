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

if(get_system_config("active_morning_ceremony")=='active'){
    
    $inputDetail['tab2']=array(
            "id"=>"morningCeremonyTab",
            "label"=>"กิจกรรมหน้าเสาธง",
            "type"=>"tab-pane",
            "class"=>""
            );
    $inputDetail['morning_ceremony_start_time'] = array(
        'label' => 'เวลาเริ่มเข้าแถว',
        'type' => 'time',
        'value'=>!empty(get_system_config("morning_ceremony_start_time"))?get_system_config("morning_ceremony_start_time"):'07:30',
    );
    $inputDetail['morning_ceremony_end_time'] = array(
        'label' => 'เวลาสิ้นสุดการเข้าแถว',
        'type' => 'time',
        'value'=>!empty(get_system_config("morning_ceremony_end_time"))?get_system_config("morning_ceremony_end_time"):'08:00',
    );
    $inputDetail['morning_ceremony_force_checking'] = array(
        'label' => 'ข้อกำหนดในการเช็คชื่อ',
        'type' => 'select',
        'item'=>array(
            'force_in_time'=>'เช็คชื่อภายในเวลาที่กำหนดเท่านั้น',
            'force_on_day'=>'เช็คชื่อได้ตลอดวัน',
        ),
        'def'=>!empty(get_system_config("morning_ceremony_force_checking"))?get_system_config("morning_ceremony_force_checking"):'force_on_day',
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
            'value'=>get_system_config("morning_ceremony_absent_signin")!=''?get_system_config("morning_ceremony_absent_signin"):15,
    );
    $inputDetail['morning_ceremony_after_check'] = array(
            'label' => 'เช็คชื่อย้อนหลังได้กี่วัน(กรณีเช็คด้วยมือ) 1 คือไม่อนุญาตให้เช็คชื่อย้อนหลัง',
            'type' => 'number',
            'attr' => array('min'=>'1'),
            'value'=>get_system_config("morning_ceremony_after_check")!=''?get_system_config("morning_ceremony_after_check"):7,
    );
}
