<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$rms=get_system_config("rms_url");
$people_data=rms_get_data($rms,'nutty','people');
$people_pro_data=rms_get_data($rms,'nutty','people_pro');
$people_pro=array();
foreach($people_pro_data as $row){
    $people_pro[$row['people_id']]=$row['people_stagov_id'];
}
$total_people=count($people_data);
//print_r($people_data);
sDeleteTb($systemDb,"userdata");
$import_people=0;
foreach($people_data as $people){
    if($people['useradmin_activity']==1||$people['useradmin_activity']==2){//1 Admin

        $user_type="admin";
    }else if($people['useradmin_activity']==3){//1 Admin

        $user_type="staff";
    }else{
        $user_type="user";

        if((is_numeric($people['people_id'])&&//ยกเว้นชาวต่างชาติ
        (!isset($people_pro[$people['people_id']])||//ไม่รับโอนข้อมูลผู้ไม่มีข้อมูลหน้าที่รับผิดชอบ
        $people_pro[$people['people_id']]==88||//ไม่รับโอนข้อมูลผู้ไม่มีหน้าที่รับผิดชอบ
        (!isValidNationalId($people['people_id'])))
        ))continue;//ไม่รับโอนข้อมูลที่รหัสประจำตัวประชาชนไม่ถูกต้อง 

    }
    $data=array(
        "people_id"=>sQ($people['people_id']),
        "username"=>sQ($people['people_user']),
        "password"=>sQ($people['people_pass']),
        "name"=>sQ($people['people_name']),
        "surname"=>sQ($people['people_surname']),
        "image_uri"=>sQ($people['people_pic']),
        "user_type"=>sQ($user_type),
        "active"=>sQ($people['people_exit']==0?'Y':'N')
    );

    $chk_user=sSelectTb($systemDb,"userdata","count(*) as c",'people_id='.sQ($people['people_id']));
    $chk_user=$chk_user[0];
    if($chk_user['c']<1){
        $result=sInsertTb($systemDb,"userdata",$data);
    }else{
        $result=sUpdateTb($systemDb,"userdata",$data,'people_id='.sQ($people['people_id']));
    }
    //print_r($result);
    if($result){
        $import_people++;
        //print "1".$people['people_user'];
    }else{
        print $systemDb['db']->error;
        //print "error";
        exit();
    }

    //print "Finish";
}

print "Finish";

?>

                            ข้อมูลบุคลากรจำนวน <?php print number_format($import_people)." จากทั้งหมด ".$total_people." คน";?> คนเรียบร้อยแล้ว
