<?php
$menu['user']= array(
    'class' => "header",
    'title' => 'ผู้ใช้',
    'cond' => true,
    'bullet' => 'person',
    'color' => 'col-blue',
    'item' => array(
        'manage' => array(
            'title' => 'โปรไฟล์',
            'url' => 'main/user/profile/general',
            'bullet' => 'nature_people',
            'color' => 'col-red',
            'cond' => false,
            ),
            
        'picture' => array(
        'title' => 'รูป',
        'url' => 'main/user/picture/general',
        'bullet' => 'nature_people',
        'color' => 'col-red',
        'cond' => false,
        ),
        'changpassword' => array(
            'title' => 'เปลี่ยนรหัสผ่าน',
            'url' => 'main/user/password/changpassword',
            'bullet' => 'nature_people',
            'color' => 'col-red',
            'cond' => true,
            ),
        ),
        
    );