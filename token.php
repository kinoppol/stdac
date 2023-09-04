<?php
$id=$_GET['id'];
$token=$_GET['token'];
$chk_token=md5($id.date(Y-m-d));
if($token!=$chk_token){
    print "Error - token expired.";
    //print $chk_token;
    exit();
}else{
    print "โปรดรอสักครู่..";
    $_SESSION['id']=$id;
    redirect(site_url('authen/login/byToken'),true,2);
}