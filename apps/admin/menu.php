<?php
$menu['admin']= array(
    'class' => "header",
    'title' => 'ดูแลระบบ',
    'cond' => current_user('user_type')=='admin',
    'bullet' => 'nature_people',
    'color' => 'col-green',
    'item' => array(
        //'billing' => array('bullet' => '',
            //'title' => 'ค่าบริการ',
            //'url' => 'main/admin/billing/manage',
            //'cond' => true,
            //),
            'managestudent' => array('bullet' => '',
                    'title' => 'กลุ่มผู้เรียน',
                    'url' => 'main/admin/managestudent/list',
                    'cond' => true,
                    ),
        'transfer' => array('bullet' => '',
                'title' => 'โอนข้อมูลผู้เรียน',
                'url' => 'main/admin/transfer/student',
                'cond' => true,
                ),
        ),
        
    );