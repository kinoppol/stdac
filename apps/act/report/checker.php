<?php

$start_date_report=$hGET['s_date'];
$end_date_report=$hGET['e_date'];
$semester=$hGET['semester'];
$semester=str_replace('-','/',$semester);

header("Content-Type: application/vnd.ms-excel"); // ประเภทของไฟล์
header('Content-Disposition: attachment; filename="stdac_'.$start_date_report.'_'.$end_date_report.'.xls"'); //กำหนดชื่อไฟล์
header("Content-Type: application/force-download"); // กำหนดให้ถ้าเปิดหน้านี้ให้ดาวน์โหลดไฟล์
header("Content-Type: application/octet-stream"); 
header("Content-Type: application/download"); // กำหนดให้ถ้าเปิดหน้านี้ให้ดาวน์โหลดไฟล์
header("Content-Transfer-Encoding: binary"); 
//header("Content-Length: ".filesize("myexcel.xls"));

$SQL='select group_id,group_short_name from '.$systemDb['prefix'].'group';
$result=$systemDb['db']->query($SQL);
$i=0;
$groups=array();
while($data=$result->fetch_assoc()){
    $i++;
    $groups[$data['group_id']]=$data['group_short_name'];
}

$SQL='select group_id,morning_ceremony_checker from '.$systemDb['prefix'].'checker where semester="'.$semester.'"';
//print $SQL;
$result=$systemDb['db']->query($SQL);
$checker=array();
while($data=$result->fetch_assoc()){
    $ck=explode(',',$data['morning_ceremony_checker']);
    foreach($ck as $pid){
        $SQL='select name,surname from '.$systemDb['prefix'].'userdata where people_id="'.$pid.'"';
        //print $SQL;
        $presult=$systemDb['db']->query($SQL);
        $pdata=$presult->fetch_assoc();
        if(!empty($checker[$data['group_id']])){
            $checker[$data['group_id']].=', '.$pdata['name'].' '.$pdata['surname'];    
        }else{
            $checker[$data['group_id']]=$pdata['name'].' '.$pdata['surname'];    
        }
    }
}
//print_r($checker);

$date_report=array();
$c_data=array();
for($cdate=$start_date_report;strtotime($cdate)<=strtotime($end_date_report);$cdate=date('Y-m-d',strtotime($cdate.' +1 days'))){
    $date_report[]=$cdate;
    $SQL='select distinct std.group_id from '.$systemDb['prefix'].'entry_record_mc erm left join '.$systemDb['prefix'].'std std on std.student_id=erm.student_id where date_check="'.$cdate.'" AND std.group_id<>""';
//print $SQL;
$result=$systemDb['db']->query($SQL);
//$i=0;
while($data=$result->fetch_assoc()){
    $c_data[$cdate][$data['group_id']]=true;
    //$i++;
    //print $i.' '.$data['group_id'].'<br>';
}
}

print "
<style>
table,td,th{
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<table>";
print "<thead>";
print "<th height=\"150\">ที่</th>";
print "<th>รหัสกลุ่ม</th>";
print "<th>ชื่อกลุ่ม</th>";
print "<th>ผู้เช็คชื่อ</th>";
foreach($date_report as $d){
print "<th style=\"
text-align:center;
white-space:nowrap;
transform-origin:50% 50%;
transform: rotate(270deg);\">".dateThai($d)."</th>";
}
print "</thead>";
print "<tbody>";
$i=0;
foreach($groups as $k=>$v){
    $i++;
    print "<tr><td>";
        print $i;
    print "</td><td>";
    print $k;
    print "</td><td>";
    print $v;
    print "</td><td>";
    print $checker[$k];
    print "</td>";
    foreach($date_report as $d){
        print "<td>".(!empty($c_data[$d][$k])?"✔":"")."</td>";
        }
    print "</tr>";    

    
}
print "</tbody>";
print "</table>";
//print_r($c_data);

