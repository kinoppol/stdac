<?php
$id=$_GET['id'];
$token=$_GET['token'];
$seed=$id.date("Y-m-d");
$chk_token=md5($seed);
if($token!=$chk_token){
    print "Error - token expired.";
    //print $chk_token;
    //print "<br>".$token;
    exit();
}else{
    //require_once('system/include/config.php');
    require_once('system/library/functions.php');
    require_once('system/library/fun/user.fun.php');
    print "โปรดรอสักครู่..";
    $_SESSION['id']=$id;
    signInUser($id,$remember=false,$noRedirect=false);
    redirect('./index.php',true,2);
}