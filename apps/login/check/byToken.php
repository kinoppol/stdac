<?php
$id=$_SESSION['id_token'];
print $id;
signInUser($id,$remember=false,$noRedirect=false);
