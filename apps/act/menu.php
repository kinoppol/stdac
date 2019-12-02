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
            'title' => 'รายชื่อกิจกรรม',
            'url' => 'main/act/view/list',
            'cond' => true,
            ),
            //'register' => array('bullet' => '',
        //'title' => 'ลงทะเบียนกิจกรรม',
        //'url' => 'main/act/list/general',
       // 'cond' => true,
       // ),
        'sum' => array('bullet' => '',
                'title' => 'สรุปผล',
                'url' => 'main/act/sum/view',
                'cond' => true,
                ),
                
                'report' => array('bullet' => '',
                'title' => 'บทสรุป',
                'url' => 'main/act/report/dashboard',
                'cond' => true,
                ),
                
        
        ),
        
    );