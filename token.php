<?php
session_start();
$id=$_GET['id'];
$token=$_GET['token'];
$seed=$id.date("Y-m-d");
$chk_token=md5($seed);
if($token!=$chk_token){
    print "Error - token expired.";
    exit();
}else{
    print '<meta charset="UTF-8">';
    print "โปรดรอสักครู่..";
    $_SESSION['id_token']=$id;
    print "<meta http-equiv=\"refresh\" content=\"2;./index.php?token=".$token."\">";
}