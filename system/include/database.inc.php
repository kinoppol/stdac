<?php
  if($user){
  $charset='utf8';
  $db = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_error())
    die("!Error : " . mysqli_connect_error());
mysqli_set_charset($db, $charset);

  }
  $systemDb=array(
            'db'=>$db,
  					'prefix'=>$prefix
  					);
  
  
  
  
  
