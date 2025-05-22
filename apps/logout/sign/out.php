<?php
load_fun('user');
unset($_SESSION['google_code']);  
unset($_SESSION['gClient']);
unset($_SESSION['token_data']);
unset($_SESSION['access_token']);
unset($_SESSION['google_data']);
unset($_SESSION['id_token']);

user_logoff();

redirect(site_url(),true);
?>
