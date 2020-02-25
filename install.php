<?php
 $setup_file="system/include/setup.cfg.php";
if(file_exists($setup_file)){
    print "ระบบได้ทำการติดตั้งเรียบร้อยแล้ว";
    print "<a href=\"./\">กลับสู่หน้าหลัก</a>";
    exit();
}


$db_server=$_POST['db_server'];
$db_user=$_POST['db_user'];
$db_password=$_POST['db_password'];
$db_name=$_POST['db_name'];
$tb_prefix=$_POST['tb_prefix'];
$rms_url=$_POST['rms_url'];
$site_url=$_POST['rms_url'];

$db=new mysqli($db_server,$db_user,$db_password,$db_name);
if($db->connect_errno){
    
    print "การเชื่อมต่อฐานข้อมูลล้มเหลวโปรดตรวจสอบอีกครั้ง";
    print "<a href=\"javascript:history.back()\">กลับไปตรวจสอบ</a>";
}

$setupFile=fopen($setup_file,"w") or die ("ไม่สามารถสร้างไฟล์ ".$setup_file." ได้โปรดตรวจสอบสิทธิ์การเข้าถึงไฟล์");

$data='
<?php
$host=\''.$db_server.'\';
$user=\''.$db_user.'\';
$password=\''.$db_password.'\';
$database=\''.$db_name.'\';
$prefix=\''.$tb_prefix.'\';
';
fwrite($setupFile,$data);
fclose($setupFile);


$SQL=file_get_contents("sample.sql");
$SQL=str_replace('`ac_','`'.$tb_prefix,$SQL);
$SQL=str_replace('RMS_URL',$rms_url,$SQL);
$SQL=str_replace('SITE_URL',$site_url,$SQL);
//print $SQL;
$db->multi_query($SQL);
/*
sleep(5);

$SQL="insert into ".$tb_prefix."userdata (username,password,active,user_type) values ('admin','".md5("admin")."','Y','admin')";
print $SQL;
$db->query($SQL);
print $db->error;
*/

print "การติดตั้งเสร็จสมบูรณ์แล้ว";
print "<a href=\"./\">ไปยังหน้าหลัก</a>";
?>

