<?php
error_reporting(0);
load_fun('activity');
$act_id=$hGET['id'];
$group_id=$hGET['grp_id'];

$check_sign='<img src="'.site_url('images/iconmonstr-check-mark-1.png',true).'" width="10">';
$late_sign='ส';
$absent_sign='<img src="'.site_url('images/x-symbol.jpg',true).'" width="10">';

$table='entry_record';
$pageSize="A4";
$pass_score=get_system_config('pass_score_activity');
if($act_id=='assembly'){
    $late_score=get_system_config("assembly_late_score")/100;
    $table.='_as';
    $date=$hGET['date'];
    $pageSize="A4-L";
    
$pass_score=get_system_config('pass_score_assembly');
}
if($act_id=='morningCeremony'){
    $late_score=get_system_config("morning_ceremony_late_score")/100;
    $table.='_mc';
    $date=$hGET['date'];
    $pageSize="A4-L";
    
$pass_score=get_system_config('pass_score_morning_ceremony');
}

$ac_data=sSelectTb($systemDb,'activity','*','id='.$act_id);
$ac_data=$ac_data[0];

$student_data=sSelectTb($systemDb,'std','*','group_id = '.$group_id);
$student_ids=array();
foreach($student_data as $std){
    $student_ids[]=$std['student_id'];

}

$group_data=sSelectTb($systemDb,'group','*','group_id = '.$group_id);
$group_data=$group_data[0];

$start_date=mb_substr($ac_data['start_time'],0,10);
$end_date=mb_substr($ac_data['end_time'],0,10);

if(is_numeric($act_id)){
    $act_name=$ac_data['name'];
    if($start_date==$end_date){
        $show_date=" ในวันที่ ".dateThai($start_date,true,true,true);
    }else{
        $show_date=" ในระหว่างวันที่ ".dateThai($start_date,true,true,true).' - '.dateThai($start_date,true,true,true);
    }
    $head_date="<th>การเข้าร่วมกิจกรรม</th>";
}else{
    if($act_id=='morningCeremony'){
        $act_name="หน้าเสาธง";
    }else if($act_id=='assembly'){
        $act_name="องค์การวิชาชีพฯ";
    }
    $show_date=' ประจำภาคเรียนที่ '.get_system_config('current_semester');

    $checker_data=sSelectTb($systemDb,'checker','*','group_id='.$hGET['grp_id'].' AND semester='.sQ(get_system_config('current_semester')));
    $checker_data=$checker_data[0];

    $holiday=sSelectTb($systemDb,'holiday','*','semester = '.sQ(get_system_config('current_semester')));
    $holidays=array();
    $ignoreDate=array();
    foreach($holiday as $row){
        if($row['in_use']=='N'){
            $ignoreDate[]=$row['holiday_date'];
        }else{
            $holidays[]=$row['holiday_date'];
        }
    }

    $semester=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ(get_system_config('current_semester')));
    $semester=$semester[0];
    //print_r($semester);
    
    if($hGET['id']=='morningCeremony'){
        $dow=explode(',',$checker_data['morning_ceremony_date']);
       }else if($hGET['id']=='assembly'){
        $dow=explode(',',$checker_data['assembly_date']);
       }

    $dates=date2date($semester['semester_start'],$semester['semester_end'],$dow,$ignoreDate);

        $head_date='';
    //print_r($dates);
    foreach($dates as $k=>$v){
        $head_date.='<th width="2%" style="vertical-align:top;" text-rotate="90">'.dateThai($k,true,false,true).'</th>';
    }
    if(count($dates)>1){
        $head_date.='<th width="2%" style="vertical-align:top;" text-rotate="90">เข้า</th>
        <th width="2%" style="vertical-align:top;" text-rotate="90">ขาด</th>
        <th width="2%" style="vertical-align:top;" text-rotate="90">%เข้า</th>
        <th width="2%" style="vertical-align:top;" text-rotate="90">ผลการประเมิน('.$pass_score.'%)</th>';
    }

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
กิจกรรม".$act_name." <br>
".$show_date."<br>
สาขาวิชา ".$group_data['major_name'].' ระดับ '.$group_data['level_name'].' กลุ่ม '.$group_data['group_short_name']."
</h3>
</td>
</tr>
</table>
";
if(is_numeric($act_id)){
    $cond='act_id='.sQ($act_id);
}else{
    $cond='student_id in ('.(implode(',',$student_ids)).') AND date_check between '.sQ($semester['semester_start']).' AND '.sQ($semester['semester_end']);
}
$check_record=sSelectTb($systemDb,$table,'*',$cond);
$record=array();
foreach($check_record as $rec){
    if(is_numeric($act_id)){
        $record[$rec['student_id']][$rec['time_entry']]=$rec['entry_type'];
    }else{
        
        $record[$rec['student_id']][$rec['date_check']]=$rec['entry_type'];
    }
}
//print_r($record);
$html.="<table cellspacing='0' width='100%' border='1'>
<thead>
<tr>
    <th width=\"3%\">ที่</th>
    <th width=\"10%\">รหัสนักศึกษา</th>
    <th width=\"20%\">ชื่อ - สกุล</th>
    ".$head_date."
</tr>
</thead>
<tbody>";

$i=0;
foreach($student_data as $std){

    
    $c=0;
    $a=0;
    $t=0;
    
    $i++;
    $html.="<tr>";
        $html.="<td style=\"text-align:right;\">".$i."</td>";
        $html.="<td style=\"text-align:center;\">".$std['student_id']."</td>";
        $html.="<td>".$std['stu_fname']." ".$std['stu_lname']."</td>";
    if(count($dates )>1){
        foreach($dates as $k=>$v){
            $t++;
            if(in_array($k,$holidays)){
                //$t--;
                $mark='*';
            }else if($record[$std['student_id']][$k]=='check'){
                $c++;
                $mark=$check_sign;
            }else if($record[$std['student_id']][$k]=='late'){
                $c+=$late_score;
                $mark=$late_sign;
            }else if(strtotime($k)<time()){
                $a++;
                $mark=$absent_sign;
            }else{
                $mark='';
            }
            $html.="<td align=\"center\">".$mark."</td>";
        }
                $html.='<td style="text-align:right;">'.$c.'</td>
            <td style="text-align:right;">'.$a.'</td>
            <td style="text-align:right;">'.number_format($c/$t*100,1).'</td>
            <td style="text-align:center;">'.(($c/$t*100<$pass_score)?"มผ.":"ผ.").'</td>';

    }else{
        if($record[$std['student_id']]=='check'){
            $mark='<img src="'.site_url('images/iconmonstr-check-mark-1.png',true).'" width="10">';
        }else if(strtotime($ac_data['end_time'])<time()){
            $mark='<img src="'.site_url('images/cross-mark.png',true).'" width="10">';
        }else{
            $mark='';
        }
        $html.="<td align=\"center\">".$mark."</td>";
    }

    $html.="</tr>";
}
$html.="</tbody>
</table>";
$html.="
".$check_sign." = มา, ".$absent_sign." = ขาด, ".$late_sign." = สาย, * วันหยุด
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
        			   'size'=>$pageSize,
        			   'fontsize'=>14,
        			   'marginL'=>12,
        			   'marginR'=>8,
        			   'marginT'=>15,
        			   'marginB'=>13,
        			   //'footer'=>'This document was created by SAS system of information centre at bangna commercial college. ',
                       'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
                    );
//print $html;       			   
genPdf($pdf_data,$pageNo=NULL,$location=$dir,$f_name);