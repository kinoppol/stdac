<?php

function afp_17($student_data){
    global $strMonthFull;
    global $systemDb;
    $TAB='<span style="visibility:hidden;" style="color:white;">XXXXXXXXX.</span>';
    $ret='';
   
    $prefix_data=array(
        '1'=>'นาย',
        '2'=>'นางสาว',
    );
    
    $ret.='<table width="100%">
    <tr>
    <td width="20%">
    </td>
       <td align="center">
          <img src="'.site_url('images/AOFTP_logo.jpg',true).'" width="125">
       </td>
       <td width="20%" valign="top" align="right">
       แบบ อวท.๑๗
       </td>
    </tr>
    </table>';
    $ret.='<div align="center">
    <b>
       ประกาศการประเมินผลกิจกรรมชมรมวิชาชีพ<br>
       ชมรมวิชาชีพ....................................... อวท. '.get_system_config('school_name').'<br>
       ภาคเรียนที่ '.thaiNum(mb_substr(get_system_config('current_semester'),0,1)).' ประจำปีการศึกษา '.thaiNum(mb_substr(get_system_config('current_semester'),2,4)).'
    </b>
    </div>';
    $ret.='<table width="100%" style="" boder="10" style="border-collapse: collapse; border: 1px solid black;">
    <thead>
    <tr>
    <th width="5%" rowspan="2" v-align="top" style="border-collapse: collapse; border: 1px solid black;">ที่</th>
    <th width="20%" rowspan="2" v-align="top" style="border-collapse: collapse; border: 1px solid black;">รหัสประจำตัว</th>
    <th width="35%" rowspan="2" v-align="top" style="border-collapse: collapse; border: 1px solid black;">ชื่อ - สกุล</th>
    <th width="20%" colspan="2" v-align="top" style="border-collapse: collapse; border: 1px solid black;">ผลการประเมิน<br>กิจกรรม</th>
    <th width="20%" rowspan="2" v-align="top" style="border-collapse: collapse; border: 1px solid black;">หมายเหตุ</th>
    </tr>
    <tr>
    <th width="10%" style="border-collapse: collapse; border: 1px solid black;">ผ่าน</th>
    <th width="10%" style="border-collapse: collapse; border: 1px solid black;">ไม่ผ่าน</th>
    </tr>
    </thead>
    <tbody>';
    $i=0;
foreach($student_data as $std){
    $prefix=$prefix_data[$std['gender_id']];
    $studentName=$prefix.$std['stu_fname'].' '.$std['stu_lname'];

    $i++;
    $ret.='<tr>
    <td align="right" style="border-collapse: collapse; border: 1px solid black;">'.thaiNum($i).'</td>
    <td align="center" style="border-collapse: collapse; border: 1px solid black;">'.thaiNum($std['student_id']).'</td>
    <td align="left" style="border-collapse: collapse; border: 1px solid black;">'.$studentName.'</td>
    <td style="border-collapse: collapse; border: 1px solid black;"></td>
    <td style="border-collapse: collapse; border: 1px solid black;"></td>
    <td style="border-collapse: collapse; border: 1px solid black;"></td>
    </tr>';

}
    
    $ret.='
    </tbody>
 </table>';
 $ret.='<table width="100%" style="">
 <tr>
 <td width="100%">
 <br>
 สรุปผลกิจกรรมชมรมวิชาชีพ...................................................... สมาชิกผ่านเกณฑ์การประเมินผลร้อยละ ...............
 </td>
       </tr>
    </table>';
    
 $ret.='<table width="100%" style="">
 <tr>
 <td width="100%">
 <br>
 '.$TAB.'ทั้งนี้ให้สมาชิกที่ไม่ผ่านการประเมินผลกิจกรรม ติดต่อยื่นคำร้องขอซ่อมกิจกรรมต่อคณะกรรมการ ประเมินผลกิจกรรม พร้อมชำระเงินค่าลงทะเบียนซ่อมกิจกรรม ตามระเบียบองค์การฯ ภายในสัปดาห์ที่ 2 ของ ภาคเรียน ถัดไป
 </td>
       </tr>
    </table>';
    $ret.='
    <table width="100%" style="">
       <tr>
       <td width="100%" align="center">
       <br>
       ลงชื่อ.......................................................................<br>
       รองผู้อำนวยการฝ่ายพัฒนากิจการนักเรียน นักศึกษา<br>
ประธานคณะกรรมการประเมินผลกิจกรรมชมรมวิชาชีพ<br>
............/................../.......... 

       </td>
       </tr>
    </table>
    ';
    
    return $ret;
 }