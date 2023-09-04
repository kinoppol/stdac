<?php
$id=$_SESSION['id_token'];
signInUser($id,$remember=false,$noRedirect=true);
print "<meta http-equiv=\"refresh\" content=\"0;./index.php\">";
