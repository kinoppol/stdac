<?php

/*
function appDb(){
  $db_host='localhost';
  $db_user='root';
  $db_pass='';
  $db_name='edsuporg_teachregis';
  $charset='utf8';
  
  $db=mysqli_connect($db_host,$db_user,$db_pass,$db_name);
  $prefix="";
  mysqli_set_charset($db, $charset);
return array('db'=>$db,
                  'prefix'=>$prefix
                  );
}
$appDb=appDb();
*/
function hs($s) {
  return htmlspecialchars($s);
}
function pq($s) {
  global $db;
  return mysqli_real_escape_string($db, $s);
}
function site_url($url='', $direct=false){
	if(substr($url,0,4)=='http'){
		return $url;
	}
        global $htacceassConfig;
  if(!$htacceassConfig&&$url!=''){$uriAdder="/?p=";}else{$uriAdder="/";}
  if (!$direct){
    if(substr(SITE_URL,strlen(SITE_URL)-9,9)=="index.php") return SITE_URL.'/'.$url;
    //return SITE_URL.'index.php/'.$url;
    return SITE_URL.$uriAdder.$url;
  }else
    return SITE_URL.'/'.$url;
}
function redirect($url='',$direct=FALSE,$delay=FALSE) {
  if(substr($url,0,4!="http")&&!$direct) $url = site_url($url);
  //print $url;
  //exit();
  if(!$delay){header('Location: ' . $url);
  exit;
             }else{
  echo '<meta http-equiv="Refresh" content="'.$delay.'; url='.$url.'" />';  
             }
    //echo '<meta http-equiv="refresh" content="0" url="'.$url.'">';
    //echo "<script>window.location.href='".$url."'</script>";
}
function gotoURL($url='') {
  echo '<meta http-equiv="Refresh" content="0; url='.$url.'" />';  
 }

  function check_auth() {
  if($_COOKIE['mem_id']==''){redirect('home/login'); exit;}
  if($_COOKIE['mem_id']!=''){
    if(chk_active_session($_COOKIE['mem_id'],$_COOKIE['token_id'])=='Y'){
    active_session($_COOKIE['mem_id'],$_COOKIE['token_id']);
      if(!isset($_SESSION['user'])){
        $_SESSION['user']=$_COOKIE['mem_id'];
        $_SESSION['mem_is_admin']=$_COOKIE['mem_is_admin'];
      }
    }else{
      setcookie('mem_id','',time+60*60*24*30,'/');
      redirect('home/logout');
      exit;
    }
  }
}

function chk_active_session($user_id,$cookie_id){
  global $db;
  global $prefix;
  $query="select active from {$prefix}session where user_id='{$user_id}' AND cookie_id='{$cookie_id}' limit 1";
  //print $query;
  $data=mysqli_query($db,$query);
  $res=mysqli_fetch_array($data);
  //print $res;
  return $res[0];
}
function active_session($user_id,$cookie_id){
  global $db;
  global $prefix;
  $query="update {$prefix}session set last_active=NOW() where user_id='{$user_id}' AND cookie_id='{$cookie_id}' limit 1";
  //print $query;
  //exit;
  return mysqli_query($db,$query);
}
function disActive_session($user_id,$session_id='*',$cookie_id='*'){
  global $db;
  global $prefix;
  if($cookie=='*')$query="update {$prefix}session set active='N' where user_id='{$user_id}'";
  else
  $query="update {$prefix}session set active='N' where user_id='{$user_id}' AND cookie_id='{$cookie_id}' AND session_id='{$session_id}' limit 1";
  //print $query;
  return mysqli_query($db,$query);
}
function gen_option($sql, $def) {
  global $db;
  global $dbPrefix;
  //print $sql;
  if (is_array($sql)) {
      
    foreach ($sql as $k => $v) {
       if(is_array($def)){
          
      $sel = in_array($k,$def) ? ' selected="selected"' : '';
       }else{
      $sel = $k==$def ? ' selected="selected"' : '';
       }
      $a[] = "<option value=\"$k\"{$sel}>$v</option>";
    }
  } else if($sql!=""){
    $res = mysqli_query($db, $sql);
    $a = array();
    while ($row = mysqli_fetch_row($res)) {
      $sel = $row[0]==$def ? ' selected="selected"' : '';
      $a[] = "<option value=\"{$row[0]}\"{$sel}>{$row[1]}</option>";
    }
  }
  if(is_array($a))return implode('', $a);
}
 

function gen_radio($name, $data, $def='', $sep='',$setPerLine=false) {
  global $db;
  $a = array();
  if (!is_array($data)) {
    $data = array();
    $res = mysqli_query($db, $data);
    while ($row = mysqli_fetch_row($res)) {
      $data[$row[0]] = $row[1];
    }
  }
  $i=0;
  foreach ($data as $k => $v) {
    $i++;
    $id = $name . '_' . $k;
    $chk = $k==$def ? ' checked="checked"' : '';
    $radioL = "<input type=\"radio\" name=\"{$name}\" id=\"{$id}\" value=\"{$k}\"{$chk}><label for=\"{$id}\"> {$v}</label> ";
    if($setPerLine&&!($i%$setPerLine)){$radioL.="<br>"; }
    $a[]=$radioL;
  }
  return implode($sep, $a);
}

function resize_image_data($img_data, $to_file, $width, $height) {
  $image = imagecreatefromstring($img_data);
  $width_orig = imagesx($image);
  $height_orig = imagesy($image);
  $ratio_orig = $width_orig/$height_orig;
  if ($width/$height > $ratio_orig) {
     $width = $height*$ratio_orig;
  } else {
     $height = $width/$ratio_orig;
  }
  $image_p = imagecreatetruecolor($width, $height);
  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
  imagejpeg($image_p, $to_file, 100);
  imagedestroy($image_p); 
  imagedestroy($image);
  return true;
}

function gen_menu($menu_id=NULL, $menu=array(), $def=NULL,$class=NULL) {
  //return 55555;
  $a = array();
  
  //return $menu;
  foreach ($menu as $k => $m) {
      $sel='';
    //print $m['cond'];
    if ($m['cond']===false)
      continue;
    if(isset($m['url']))$href = site_url($m['url']);
    if (isset($m['param']))
      $href .= '&' . $m['param'];
    if($m['class'])$class_string='class="'.$m['class'].'"';
    $a[] = '<li '.$sel.''.$class_string.'>'.$m['title'].'</li>';
    if($m['item']){
      $tree="";
      foreach($m['item'] as $sk=>$sv){
        // print_r($def); 
          if ($sv['cond']===false)
      continue;
    $sel = $k==$def['app'] && $sk==$def['function'] ? 'active ' : '';
        
        $bullet=$sv['bullet'];
          if(!$sv['bullet']){ $bullet="fa fa-circle-o text-aqua";}
        $url="#";
          if(isset($sv['url']))$url=site_url($sv['url']);
        
        if(!isset($sv['item'])||!count($sv['item'])){
          $tree.='<li class="'.$sel.'"><a href="'.$url.'"><i class="'.$bullet.'"></i> <span>'.$sv['title'].'</span></a></li>';          
        }else if(count($sv['item'])){
          
           $tree.="
        <li class='".$sel."treeview'>";
          
          $tree.='<a href="'.$url.'"><i class="'.$bullet.'"></i><span>'.$sv['title'].'</span><i class="'.($bullet!=''?$bullet:'fa fa-angle-left pull-right').'"></i></a>';
          
      $tree.="
        <ul class='treeview-menu'>";
      foreach($sv['item'] as $key=>$value){
        if(isset($value['cond']))if ($value['cond']===false)
      continue;
          $url="#";
          if($value['url'])$url=site_url($value['url']);
        //print_r($value);
          //print $key.">=<".$def['file'];
        $sel = $key==$def['file'] ? ' class="active"' : '';
        //print $sel;
        $tree.='<li'.$sel.'><a href="'.$url.'">';
        $bullet='fa fa-circle-o';
        if($value['bullet'])$bullet=$value['bullet'];
        $tree.='<i class="'.$bullet.'"></i>';
        $tree.=$value['title'];
        if(isset($value['num']))$tree.='<span class="label label-primary pull-right">'.$value['num'].'</span>';
        $tree.='</a></li>';
        
              }
          $tree.="</ul>";
          
        $tree.="</li>";
        }
        
              }
      $a[]=$tree;
    }
  }
  return '<ul id="' . $menu_id . '" class="' . $class . '">' . implode('', $a) . '</ul>';
}
  
  //additional function
  
  function load_fun($name_func){
    if($name_func){
      $func_path=LIB_PATH."fun/".$name_func.".fun.php";
      //print $func_path;
      if(file_exists($func_path)) include_once($func_path);
    } 
  }
  
 function loadAppLib($appName,$libName){
    if($appName&&$libName){
      $func_path=APP_PATH.$appName."/library/".$libName.".lib.php";
      //print $func_path;
      if(file_exists($func_path)) include_once($func_path);
    } 
  }

  function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
  
  function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
  

  
  function get_system_config($name,$exist=false){
    global $db;
    global $prefix;
    
    $query="select * from {$prefix}site_config where config_name='{$name}' limit 1";
    //print json_encode($query);
    $result=mysqli_query($db,$query);
    
    //print_r( $db);
    $data=mysqli_fetch_array($result);
    if(mysqli_num_rows($result)){
      if($exist){
        return 1;
      }else{
        return $data['detail'];
      }
    }else{
    return false;
    }
    
  }
  function update_system_config($name,$value){
    global $db;
    global $prefix;
    
    if(get_system_config($name,true)){
      $query="update {$prefix}site_config set detail = '{$value}' where config_name='{$name}' limit 1";
    }else{
      $query="insert into {$prefix}site_config (config_name,detail) values ('{$name}','{$value}')";
    }
    //print json_encode($query);
    $result=mysqli_query($db,$query);
    
    return $result;
    
  
  }
  
  function autoLoad($funList=array()){
    foreach($funList as $v){
      load_fun($v);
            
            }
  }
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function includeAppLib($appName){
    $dir=APP_PATH.$appName.'/library';
    //print $dir;
    if(is_dir($dir)){
        foreach (glob($dir."/*.php") as $filename)
            {
            include_once $filename;
            }
    }
}

function strLim($str,$lim=NULL,$tail='..',$returnArray=false,$psSign=''){
   $orgStr=$str;
    if($lim){
        if(mb_strlen($str)>$lim){
            $str=mb_substr($str,0,$lim-mb_strlen($tail)).$tail.$psSign;
        }
    }
    if($returnArray){
      $ps=$str!=$orgStr?$orgStr:'';
      return array($str,$ps);
    }else{
      return $str;
    }
}

function sQ($data,$force=false,$sign="'"){
	if($force){
		$ret=$sign.addslashes ($data).$sign;
	}else{
		$ret=is_numeric($data)?$data:$sign.addslashes ($data).$sign;
	}
	return $ret; 
}

function dateThai($strDate,$fullM=false,$thNum=false,$fullY=false){
   global $strMonthFull;
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		//$strMinute= date("i",strtotime($strDate));
		//$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		
		                     if($fullM){
		                        
		$strMonthThai=$strMonthFull[$strMonth];
		                     }else{
		$strMonthThai=$strMonthCut[$strMonth];
		                     }
		                     if($fullY){
		                      ;  
		                     }else{
		$strYear=mb_substr($strYear,2,2);
		                     }
		$ret= "$strDay $strMonthThai $strYear";//, $strHour:$strMinute";
      if($thNum)$ret=thaiNum($ret);
      return $ret;
	}

function thaiNum($str){
   $thNum=array(
      '0'=>'๐',
      '1'=>'๑',
      '2'=>'๒',
      '3'=>'๓',
      '4'=>'๔',
      '5'=>'๕',
      '6'=>'๖',
      '7'=>'๗',
      '8'=>'๘',
      '9'=>'๙',);
   return strtr($str,$thNum);
}
function gen_modal($data){
	global $systemFoot;
	global $systemTop;
	$ret='<div class="modal fade" id="'.$data['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title" id="myModalLabel">'.$data['title'].'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>-->
      </div>
    </div>
  </div>
</div>';
								
								$systemFoot.='<script>
								$( document ).ready(function() {


			$("#'.$data['id'].'").on("show.bs.modal", function(e) {
    var link = $(e.relatedTarget);
    $(this).find(".modal-body").html("<i class=\"fa fa-refresh fa-spin\"></i> กำลังโหลดโปรดรอสักครู่");
    $(this).find(".modal-body").load(link.attr("href"));
});
});
$("#'.$data['id'].'").on("hidden.bs.modal", function () {
  '.$data['onClose'].'
})
								</script>';
								return $ret;
}
function gen_modal_botton($data=array()){
  if(!isset($data['color']))$data['color']='btn-default';
  $onlyClickClose='';
  if($data['onlyClickClose']==true){
      $onlyClickClose=' data-backdrop="static" data-keyboard="false"';
  }
  $ret='
  <button type="button" class="btn '.$data['color'].'" onClick="'.$data['onClick'].'" data-toggle="modal" data-target="#'.$data['id'].'"'.$onlyClickClose.'>
          '.$data['label'].'
  </button>';

  return $ret;
}

function gen_modal_box($data=array()){
  $ret='
  <div class="modal fade" id="'.$data['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog'.$data['size'].'">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">'.$data['title'].'</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
    
      '.$data['content'].'
      
    </div>
    <div class="modal-footer">
      <!--<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>-->
    </div>
  </div>
</div>
</div>
</div>
';
return $ret;
}

function gen_modal_link($data){
	if($data['onlyClickClose'])$onlyClickClose='data-keyboard="false" data-backdrop="static"';
	$ret='';
	$ret='href="'.site_url($data['src']).'" data-target="#'.$data['id'].'" data-toggle="modal" data-remote="false" '.$onlyClickClose;
	return $ret;
}
$dow=array(
	'0'=>'sunday',
	'1'=>'monday',
	'2'=>'tuesday',
	'3'=>'wednesday',
	'4'=>'thursday',
	'5'=>'friday',
	'6'=>'saturday'
	);
$dowThai=array(
	'0'=>'อาทิตย์',
	'1'=>'จันทร์',
	'2'=>'อังคาร',
	'3'=>'พุธ',
	'4'=>'พฤหัสบดี',
	'5'=>'ศุกร์',
	'6'=>'เสาร์'
	);
$strMonthFull = array("","มกราคม",
		                     "กุมภาพันธ์",
		                     "มีนาคม",
		                     "เมษายน",
		                     "พฤษภาคม",
		                     "มิถุนายน",
		                     "กรกฎาคม",
		                     "สิงหาคม",
		                     "กันยายน",
		                     "ตุลาคม",
		                     "พฤศจิกายน",
		                     "ธันวาคม");
$namePrefix=array(
            0=>'เด็กชาย',
            1=>'เด็กหญิง',
            2=>'นาย',
            3=>'นางสาว',
            4=>'นาง',
            
   );
$leaveType=array(
              	   'sick'=>'ลาป่วย',
              	   'maternity'=>'ลาคลอดบุตร',
              	   'helpTheWife'=>'ลาไปช่วยเหลือภริยาที่คลอดบุตร',
              	   'business'=>'ลากิจส่วนตัว',
              	   'relax'=>'ลาพักผ่อน',
              	   'religion'=>'ลาอุปสมบทหรือการลาไปประกอบพิธีฮัจย์',
              	   'military'=>'ลาเข้ารับการตรวจเลือกหรือเข้ารับการเตรียมพล',
              	   'educational'=>'ลาไปศึกษา ฝึกอบรม ดูงาน หรือปฏิบัติการวิจัย',
              	   'interORG'=>'ลาไปปฏิบัติงานในองค์การระหว่างประเทศ',
              	   'spouse'=>'ลาติดตามคู่สมรส',
              	   'rehabilitation'=>'ลาไปฟื้นฟูสมรรถภาพด้านอาชีพ',
              	   );
function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

function array_kshift(&$arr)
{
  list($k) = array_keys($arr);
  $r  = array($k=>$arr[$k]);
  unset($arr[$k]);
  return $r;
}

//สาเหตุของการไม่สแกนนิ้วมือ
$causeData=array(
		   'forget'=>'ลืมสแกนลายนิ้วมือ',
		   'scaner_error'=>'สแกนไม่ติด',
		   'business'=>'ขออนุญาตกลับก่อน',
		   'busy'=>'ติดภารกิจอื่น',
		   'SBH'=>'ลงชื่อด้วยลายมือ',
		   'late'=>'ลงชื่อเข้าสาย'
		   );
function AD_date($strDate,$errYear=10){
   $year=mb_substr($strDate,0,4);
   if(abs($year-date('Y'))>$errYear){
      $year-=543;
      return $year.mb_substr($strDate,4,mb_strlen($strDate)-4);
   }else{
      return $strDate;
   }
}

$time_due=array(
   1=>'08',
   2=>'09',
   3=>'10',
   4=>'11',
   5=>'12',
   6=>'13',
   7=>'14',
   8=>'15',
   9=>'16',
   10=>'17',
   11=>'18',
   12=>'19',
   );

   function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function base64url_encode($s) {
  return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
}

function base64url_decode($s) {
  return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
}