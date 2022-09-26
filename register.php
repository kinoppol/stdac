<?php 
require_once('version.php');
require_once('system/include/setup.cfg.php');
require_once('system/include/database.inc.php');

    $SQL='select * from '.$systemDb['prefix'].'site_config  where config_name="siteURL"';
    //print $SQL;
    $result=$systemDb['db']->query($SQL);
    $data=$result->fetch_assoc();
    $URL="https://vas.edsup.org/api/?s=".trim($data['detail'])."&v=".$version;
    //print $URL;
    echo file_get_contents($URL);
?>