<?php
error_reporting(0);
$act_id=$hGET['id'];
$group_id=$hGET['grp_id'];

$ac_data=sSelectTb($systemDb,'activity','*','id='.$act_id);
$ac_data=$ac_data[0];

$student_data=sSelectTb($systemDb,'std','*','group_id = '.$group_id);

$group_data=sSelectTb($systemDb,'group','*','group_id = '.$group_id);
$group_data=$group_data[0];

$start_date=mb_substr($ac_data['start_time'],0,10);
$end_date=mb_substr($ac_data['end_time'],0,10);

if($start_date==$end_date){
    $show_date=" ในวันที่ ".dateThai($start_date,true,true,true);
}else{
    $show_date=" ในระหว่างวันที่ ".dateThai($start_date,true,true,true).' - '.dateThai($start_date,true,true,true);
}

$prefix=array(
    '3'=>'นางสาว',
    '2'=>'นาย',
    '1'=>'เด็กชาย',
    '2'=>'เด็กหญิง',
    '5'=>'นาง',

);

$html="<table width=\"100%\">
<tr>
<td style=\"text-align:center\">
<h3>รายงานการเข้าร่วมกิจกรรม<br>
กิจกรรม ".$ac_data['name']." <br>
".$show_date."<br>
สาขาวิชา ".$group_data['major_name'].' ระดับ '.$group_data['level_name'].' กลุ่ม '.$group_data['group_short_name']."
</h3>
</td>
</tr>
</table>
";

$cond='act_id='.sQ($act_id);
$check_record=sSelectTb($systemDb,'entry_record','*',$cond);
$record=array();
foreach($check_record as $rec){
    $record[$rec['student_id']]=$rec['entry_type'];
}

$html.="<table cellspacing='0' width='100%' border='1'>
<thead>
<tr>
    <th>ที่</th>
    <th>รหัสนักศึกษา</th>
    <th>ชื่อ - สกุล</th>
    <th>การเข้าร่วมกิจกรรม</th>
</tr>
</thead>
<tbody>";
$i=0;

foreach($student_data as $std){

    if($record[$std['student_id']]=='check'){
        $mark='<img src="'.site_url('images/check-mark.png',true).'" width="10">';
    }else{
        $mark='';
    }
    $i++;
    $html.="<tr>";
        $html.="<td style=\"text-align:right;\">".$i."</td>";
        $html.="<td style=\"text-align:center;\">".$std['student_id']."</td>";
        $html.="<td>".$std['stu_fname']." ".$std['stu_lname']."</td>";
        $html.="<td style=\"text-align:center;\">".$mark."</td>";
    $html.="</tr>";
}
$html.="</tbody>
</table>";
$html.="
<table width=\"100%\">
<tr>
<td style=\"text-align:center\">
<br>
<br>
<h3>
......................................................<br>
(......................................................)<br>
ผู้รายงาน
</h3>
</td>
</tr>
</table>
";


load_fun('mpdf');
$pdf_data=array(
        			   'html'=>$html,
        			   'size'=>"A4",
        			   'fontsize'=>14,
        			   'marginL'=>18,
        			   'marginR'=>10,
        			   'marginT'=>15,
        			   'marginB'=>13,
        			   'footer'=>'This document was created by SAS system of information centre at bangna commercial college. ',
                       //'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
                    );
//print $html;       			   
genPdf($pdf_data,$pageNo=NULL,$location=$dir,$f_name);