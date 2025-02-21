<?php
 //ini_set('display_errors', 1);
 //ini_set('display_startup_errors', 1);
 //error_reporting(E_ALL);
error_reporting(0);

$year=$_POST['year'];
$semester=$_POST['semester'];

$html="<table width=\"100%\">
<tr>
<td style=\"text-align:center\">
<h3>รายงานสรุปการจัดกิจกรรม<br>
ภาคเรียนที่ ".$semester." ปีการศึกษา
".$year."<br>
</h3>
</td>
</tr>
</table>
";


$act_data=sSelectTb($systemDb,'activity','*','year='.sQ($year).' AND semester='.sQ($semester).' order by start_time');

$html.="<table cellspacing='0' width='100%' border='1'>
<thead>
<tr>
    <th width=\"3%\">ที่</th>
    <th width=\"72%\">ชื่อกิจกรรม</th>
    <th width=\"5%\" text-rotate=\"90\" style=\"vertical-align:bottom;\">จำนวนผู้มีรายชื่อ</th>
    <th width=\"5%\" text-rotate=\"90\" style=\"vertical-align:bottom;\">จำนวนผู้เข้าร่วมกิจกรรม</th>
    <th width=\"5%\" text-rotate=\"90\" style=\"vertical-align:bottom;\">จำนวนผู้ไม่ได้เข้าร่วมกิจกรรม</th>
    <th width=\"5%\" text-rotate=\"90\" style=\"vertical-align:bottom;\">ร้อยละของผู้เข้าร่วมกิจกรรม</th>
    <th width=\"5%\" text-rotate=\"90\" style=\"vertical-align:bottom;\">ร้อยละของผู้ไม่เข้าร่วมกิจกรรม</th>
</tr>
</thead>
<tbody>";
$i=0;

foreach($act_data as $act){
    $i++;


    
$groups=json_decode($act['group_id'],true);
$student_id_data=sSelectTb($systemDb,'std','student_id','group_id in ('.implode(',',$groups).')');
$student_ids=array();
foreach($student_id_data as $std_id){
    array_push($student_ids,$std_id['student_id']);
}
//$student_amout=$student_amout[0];

$student_check_amout=sSelectTb($systemDb,'entry_record','count(distinct student_id) as c','act_id='.$act['id'].' AND entry_type="check" AND student_id IN ('.implode(',',$student_ids).')');
$student_check_amout=$student_check_amout[0];

$total=count($student_ids);
$present=$student_check_amout['c'];

    $html.="<tr>";
    $html.="<td style=\"text-align:right;\">".$i."</td>";
    $html.="<td>".$act['name']."</td>";
    $html.="<td style=\"text-align:right;\">".number_format($total)."</td>";
    $html.="<td style=\"text-align:right;\">".number_format($present)."</td>";
    $html.="<td style=\"text-align:right;\">".number_format($total-$present)."</td>";
    $html.="<td style=\"text-align:right;\">".number_format(($present/$total)*100,2)."</td>";
    $html.="<td style=\"text-align:right;\">".number_format((($total-$present)/$total)*100,2)."</td>";

    $html.="</tr>";
}
$html.="
</tbody>
</table>";
load_fun('mpdf');
$pdf_data=array(
        			   'html'=>$html,
        			   'size'=>"A4-L",
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
