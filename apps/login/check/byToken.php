<?php
$id=$_SESSION['id_token'];
signInUser($id,$remember=false,$noRedirect=false);