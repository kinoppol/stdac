<?php
    //print_r($_POST);
    if($_POST['password']==''){
        print "รหัสผ่านต้องไม่ว่าง";

    }else if($_POST['password']!=$_POST['confirmpassword']){
        print "รหัสผ่านไม่ตรงกัน";

    }else if(mb_strlen($_POST['password'])<8){
        print "รหัสผ่านต้องไม่น้อยกว่า 8 ตัว";

    }else{
        $data=array(
            'password'=>sQ(md5($_POST['password'])),
        );
        $result=sUpdateTb($systemDb,'userdata',$data,'id='.current_user('id'));
    }

    if($result){
        print "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว";
    }else{
        print " เปลี่ยนรหัสผ่านไม่สำเร็จ";    
    }
?>