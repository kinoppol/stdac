<?php
$menu['atc']= array(
    'class' => "header",
    'title' => 'กิจกรรม',
    'cond' => true,
    'bullet' => 'nature_people',
    'color' => 'col-red',
    //'url' => 'main/act/form/general',
    'item' => array(
        'list' => array('bullet' => '',
            'title' => 'รายชื่อกิจกรรมกลาง',
            'url' => 'main/act/view/list',
            'cond' => current_user('user_type')=='admin',
            ),
        'listMorningCeremony' => array('bullet' => '',
            'title' => 'เช็คชื่อกิจกรรมหน้าเสาธง',
            'url' => 'main/act/morningCeremony/list',
            'cond' => get_system_config("active_morning_ceremony")=='active',
            ),
        'listAssembly' => array('bullet' => '',
                'title' => 'เช็คชื่อชั่วโมงกิจกรรม',
                'url' => 'main/act/assembly/list',
                'cond' => get_system_config("active_assembly")=='active',
                ),
            //'register' => array('bullet' => '',
        //'title' => 'ลงทะเบียนกิจกรรม',
        //'url' => 'main/act/list/general',
       // 'cond' => true,
       // ),
       
        'check' => array('bullet' => '',
                'title' => 'ตรวจสอบการเช็คชื่อ',
                'url' => 'main/act/report/check_checker',
                'cond' => current_user('user_type')=='admin',
                ),
        'sum' => array('bullet' => '',
                'title' => 'สรุปผล',
                'url' => 'main/act/sum/view',
                'cond' => current_user('user_type')=='admin',
                ),
                
                'report' => array('bullet' => '',
                'title' => 'บทสรุป',
                'url' => 'main/act/report/dashboard',
                'cond' => current_user('user_type')=='admin',
                ),
                
        
        ),
        
    );