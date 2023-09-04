<?php
$id=$_GET['id'];
$token=$_GET['token'];
$seed=$id.date("Y-m-d");
$chk_token=md5($seed);
if($token!=$chk_token){
    print "Error - token expired.";
    exit();
}else{
    print "โปรดรอสักครู่..";
    $_SESSION['id']=$id;
    print "<meta refresh=\"index.php?token=\"".$token.">";
}