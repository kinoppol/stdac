<?php
if(0){
print "กำลังปรับปรุงข้อมูล.. รอสักครู่";
exit();
}
$startRender=microtime(true);
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
define('INDEX_PATH', str_replace('\\','/',dirname(__FILE__)).'/');

include('system/include/config.php');

$theme=get_system_config("theme");
$systemTitle=get_system_config('siteName');
$systemSubTitle=get_system_config('subName');
$displayUserName=current_user('name')." ".current_user('surname');

$userPanel=array(   'name'=>$displayUserName,
                    'picture'=>current_user('picture')
                  );

include BASE_PATH."system/template/".$theme."/library.php";
$cUserID=current_user('user_id');
//if($cUserID){
//$activeUser=sInsertTb($systemDb,'user_online',array('time_active'=>'NOW()','user_id'=>$cUserID,'session_id'=>sQ($_COOKIE['PHPSESSID'])));
//print_r($_COOKIE);
//}

function get_include_contents($filename) {
    $filename=BASE_PATH.$filename;
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        ob_end_flush();
        return sanitize_output($contents);
    }
    return false;
  }  

  global $htacceassConfig;
  if($htacceassConfig){
  $hGET=array_reverse($_GET);
  }else{
    $str=explode('/',$_GET['p']);
    $num=0;
    $hGET=array();
    foreach($str as $v){
      if($num%2){
        $hGET[$key]=$v;
      }else{
        $key=$v;
      }
      $num++;
    }
  }
  $template = key($hGET);
  $app= array_shift($hGET);
  $function= key($hGET);
  $file= array_shift($hGET);

  includeAppLib($app);

  $breadcrumb='<ul class="breadcrumb">
  <li>
    <i class="ace-icon fa fa-home home-icon"></i>
    <a href="'.site_url().'">Home</a>
  </li>
  <li class="active">'.$app.'</li>
  <li class="active">'.$function.'</li>
  <li class="active">'.$file.'</li>
</ul>';
//ตรวจสอบ การระบุหน้า

//exit();
if(!isset($_COOKIE['start_page'])&&($template!="ajax"||!$_SESSION['siteConfig']['siteURL']&&template!='ajax')){
    setcookie('start_page', 'no', time() + (86400 * 30), "/"); // 86400 = 1 day
    if($template!="public"){
    	gotoURL('./');
     	redirect(site_url(),true,5); // รีเฟรช 1 ครั้งถ้าเป็นการเข้าหน้าเว็บครั้งแรก เพื่อให้อ่านค่าจาก Cookie ได้
    	exit();
    }
  }
    if(current_user('id')==false&&$app!="login"&&$app!="signup"&&$file!='logoff'&&$template!="ajax"&&$template!="public"){

        if(isset($_SESSION['access_token'])&&$_SESSION['access_token']!=''){
          print_r($_SESSION['access_token']);
          print "Hello";
          if($template!="public")redirect(site_url("authen/login/google/redirect/"),true);
        }else if(last_user('id')){
            redirect(site_url("authen/login/form/lockscreen/"),true);
        }else{
      if($template!="public")redirect(site_url("authen/login/form/regular/"),true);
    }
      
    }else{
      
      if((!$template&&!$app&&!$function&&!$file)&&(current_user('id'))){
          //selectAcademy(current_user('academy_id'));
              /*if(current_user('default_uri')&&current_user('user_id')){
                  define('SITE_URL', get_system_config('siteURL'));
              redirect(current_user('default_uri'));
              }else{*/
                if(!$template)$template='main';
                if(!$app)$app='home';
                if(!$function)$function='dashboard';
                if(!$file)$file='view';    
              //}
      }elseif(!$template||!$app||!$function||!$file){
      redirect("main/system/error/500");
  }
    }
//สิ้นสุดการตรวจสอบ
$curCRI=$template.'/'.$app.'/'.$function.'/'.$file;
//$fileContent=APP_PATH.$app."/".$function."/".$file.".php";
$fileContent='apps/'.$app."/".$function."/".$file.".php";
  if(!file_exists($fileContent)){
   $url=site_url($curCRI);
    $incfile ="apps/system/error/404.php";
  }else{
    $incfile = $fileContent;
  }
 
  include $incfile;
  $content = ob_get_contents();
  if (ob_get_contents()) ob_end_clean();
  ob_end_flush();

$fileNotification="system/include/notificationMenu.inc.php";
$notificationMenu_content= get_include_contents($fileNotification);
/*
$fileMenu="system/include/mainMenu.inc.php";

include($fileMenu);

$fileSidebar="system/include/sidebar.inc.php";
$sidebar_content = get_include_contents($fileSidebar);
*/
$themeUrl=site_url("system/template/".$theme."/source/",true);    
//$systemTop.='<link rel="stylesheet" href="'.$themeUrl.'assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />';

include BASE_PATH."system/template/".$theme."/".$template.".php";