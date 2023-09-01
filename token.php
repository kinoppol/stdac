<?php
$id=$_GET['id'];
$token=$_GET['token'];
$chk_token=md5($id.date(Y-m-d));
if($token!=$chk_token){
    print "Error - token expired.";
    exit();
}