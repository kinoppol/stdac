<?php
  date_default_timezone_set('Asia/Bangkok');
  define('INC_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
  define('BASE_PATH', INDEX_PATH);// INDEX_PATH กำหนดไว้ที่ไฟล์ index.php
  define('LIB_PATH', BASE_PATH.'system/library/');
  define('THEME_PATH', BASE_PATH.'system/template/');
  define('APP_PATH', BASE_PATH.'apps/');
  //define('ADMIN_PATH', BASE_PATH.'admin/');

  if(isset($_SESSION['siteConfig']['siteURL'])){
    define ('SITE_URL',$_SESSION['siteConfig']['siteURL']);
   }
//print APP_PATH;
//exit();

  define('DEBUG', 'YES');
 
  
  ///////////////////////////////////////////////////////////
  
  
  $charset = 'utf8';
 
  include_once LIB_PATH.'functions.php';
    $function_list=array('sTinyDB','user','ajaxSystemAlert','wallet');
  autoLoad($function_list);
  ///////////////////////////////////////////////////////////
  //ถ้ากำหนด URL ภายในเว็บด้วย .htaccess
  $htacceassConfig=false;
 $setup_file=BASE_PATH."system/include/setup.cfg.php";
  ///////////////////////////////////////////////////////////
  if(file_exists($setup_file)){
    include_once($setup_file);
     
include(BASE_PATH."system/include/database.inc.php");

     $htacceassConfig=get_system_config('htaccess');

      // Database config
  
  //load_fun('tinyDB');


    if(!isset($_SESSION['siteConfig']['siteName'])){
        $siteURLData=get_system_config('siteURL');
        $siteName_data=get_system_config('siteName');
        $subName_data=get_system_config('subName');
    $_SESSION['siteConfig']['siteURL']=$siteURLData;
    $_SESSION['siteConfig']['siteName']=$siteName_data;
    $_SESSION['siteConfig']['subName']=$subName_data;

    define ('SITE_URL',$_SESSION['siteConfig']['siteURL']);
    //exit();
    }
    
    if(DEBUG=="NO"){
    defined('SITE_URL') or die('ERROR_SITE_URL');
    error_reporting(0);
    }else{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    }
    
    if(DEBUG=="YES"){ error_reporting(E_ERROR |E_WARNING | E_PARSE );}
    /*
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    define('JS_URL', SITE_URL.'js/');
    define('CSS_URL', SITE_URL.'css/');
    define('IMG_URL', SITE_URL.'image/');
    */
  }else{
    
    /*
    print_r($_SESSION);
    print_r($_COOKIE);
    print_r($_GET);
    print_r($_POST);
    exit();
    */
  }
  
  $province_thai=array("จังหวัด","กระบี่","กรุงเทพมหานคร","กาญจนบุรี","กาฬสินธุ์","กำแพงเพชร","ขอนแก่น","จันทบุรี","ฉะเชิงเทรา","ชลบุรี","ชัยนาท","ชัยภูมิ","ชุมพร","เชียงราย","เชียงใหม่","ตรัง","ตราด","ตาก","นครนายก","นครปฐม","นครพนม","นครราชสีมา","นครศรีธรรมราช","นครสวรรค์","นนทบุรี","นราธิวาส","น่าน","บุรีรัมย์","บึงกาฬ","ปทุมธานี","ประจวบคีรีขันธ์","ปราจีนบุรี","ปัตตานี","พระนครศรีอยุธยา","พะเยา","พังงา","พัทลุง","พิจิตร","พิษณุโลก","เพชรบุรี","เพชรบูรณ์","แพร่","ภูเก็ต","มหาสารคาม","มุกดาหาร","แม่ฮ่องสอน","ยโสธร","ยะลา","ร้อยเอ็ด","ระนอง","ระยอง","ราชบุรี","ลพบุรี","ลำปาง","ลำพูน","เลย","ศรีสะเกษ","สกลนคร","สงขลา","สตูล","สมุทรปราการ","สมุทรสงคราม","สมุทรสาคร","สระแก้ว","สระบุรี","สิงห์บุรี","สุโขทัย","สุพรรณบุรี","สุราษฎร์ธานี","สุรินทร์","หนองคาย","หนองบัวลำภู","อ่างทอง","อำนาจเจริญ","อุดรธานี","อุตรดิตถ์","อุทัยธานี","อุบลราชธานี");
  $day_thai =array("จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์");
  $month_thai =array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน",
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"
  );
  
  $num_thai=array(
    "0"=>"๐",
    "1"=>"๑",
    "2"=>"๒",
    "3"=>"๓",
    "4"=>"๔",
    "5"=>"๕",
    "6"=>"๖",
    "7"=>"๗",
    "8"=>"๘",
    "9"=>"๙",
  );

  function thai_date_time($time,$shot=false){  
    global $day_thai;
    global $month_thai;  
    $time=strtotime($time);
    if(!$shot)$thai_date_return="วัน".$day_thai[date("w",$time)];  
    if(!$shot)$thai_date_return.= "ที่ ";
    $thai_date_return.= date("j",$time);  
    if(!$shot)$thai_date_return.=" เดือน"; else $thai_date_return.=" ";
    $thai_date_return.= $month_thai[date("n",$time)];  
    if(!$shot)$thai_date_return.= " พ.ศ.";
    $thai_date_return.= " ".(date("Yํ",$time)+543);  
    if(!$shot)$thai_date_return.= " เวลา";
    $thai_date_return.=" ".date("H:i",$time)." น.";  
    return $thai_date_return;  
}  
  
  $AdminLTE_color=array("red","green","aqua","yellow","blue","navy","teal","olive","lime","orange","fuchsia","purple","maroon","black","gray");
