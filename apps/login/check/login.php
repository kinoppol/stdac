<?php
$username=$_POST['username'];
$password=$_POST['password'];
if($id=check_user_pass($username,$password)){
    signInUser($id,$remember=$_POST['remember'],$noRedirect=false);
    print_r($_COOKIE);
    //redirect(site_url());
}else{
    print '
    โปรดรอสักครู่
    <script>
    alert("Error ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
    </script>';
    redirect(site_url(),true,5);
    exit();
}