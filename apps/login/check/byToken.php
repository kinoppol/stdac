<?php
$id=$_SESSION['id_token'];
print $id;
$data=sSelectTb($systemDb,'userdata','id','people_id="'.$id.'" AND active="Y" limit 1');
$userdata=$data[0];
signInUser($userdata['id'],$remember=false,$noRedirect=false);
unset($_SESSION['id_token']);
