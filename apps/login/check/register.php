<?php

$username=trim($_POST['username']);
$email=trim($_POST['email']);
$password=trim($_POST['password']);
$confirmPassword=trim($_POST['confirmPassword']);

if($username!==''&&$email!==''&&$password!==''&&$confirmPassword!==''){

    if($password==$confirmPassword){

        if(mb_strlen($password)>=8){
            $password=md5($password);

            $check_user=sSelectTb($systemDb,'userdata','count(*) as c','username='.sQ($username));
            $check_user=$check_user[0];
            if($check_user['c']<1){
                $check_email=sSelectTb($systemDb,'userdata','count(*) as c','email='.sQ($email));
                $check_email=$check_email[0];
                if($check_email['c']<1){

                    $data=array(
                        'username'=>sQ($username),
                        'email'=>sQ($email),
                        'password'=>sQ($password),
                    );

                    $add_user=sInsertTb($systemDb,'userdata',$data);
                    if($add_user){
                        print "<p>สมัครสมาชิกสำเร็จ</p>";
                        print "<a href=\"".site_url('authen/login/form/regular')."\" class=\"btn btn-success\">ลงชื่อเข้าใช้</a>";
                    }else{
                        print "<p>การสมัครสมาชิกล้มเหลว, กรุณาตรวจสอบข้อมูลอีกครั้ง</p>";
                        print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a> ";
                    }
                
                }else{
                    print "<p>มีผู้ใช้เมล ".$email." อยู่แล้ว, กรุณาเปลี่ยนอีเมล หรือกู้คืนรหัสผ่าน</p>";
                    print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a> ";
                    print "<a href=\"".site_url('authen/login/form/forget')."\" class=\"btn btn-success\">กู้คืนรหัสผ่าน</a>";
                }

            }else{
                print "<p>มีผู้ใช้ชื่อ ".$username." อยู่แล้ว, กรุณาเปลี่ยนชื่อผู้ใช้</p>";
                print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a>";
            }


        }else{
            print "<p>รหัสผ่านจะต้องไม่น้อยกว่า 8 ตัวอักษร, กรุณาตรวจสอบข้อมูลอีกครั้ง</p>";
            print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a>";
        }

    }else{
        print "<p>รหัสผ่านที่ระบุไม่ตรงกัน, กรุณาตรวจสอบข้อมูลอีกครั้ง</p>";
        print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a>";
    }

}else{
    print "<p>ข้อมูลไม่สมบูรณ์, กรุณาตรวจสอบข้อมูลอีกครั้ง</p>";
    print "<a href=\"#\" onClick=\"goBack()\" class=\"btn btn-danger\">กลับ</a>";
    
}

print "<script>
    function goBack() {
      window.history.back();
    }
    </script>";