<?php

function signUpFrom_06($code){
   global $strMonthFull;
   global $systemDb;
   $ret='';
  
   $prefix_data=array(
       '1'=>'นาย',
       '2'=>'นางสาว',
   );
   
   $level_data=array(
      '2'=>'ปวช. ',
      '3'=>'ปวส. ',
      '4'=>'ปวส. ',
   );

   $TAB='<span style="visibility:hidden;" style="color:white;">XXXXXXXXX.</span>';
   $student_data=sSelectTb($systemDb,'std','*','student_id='.sQ($code));
$student_data=$student_data[0];
$group_data=sSelectTb($systemDb,'group','*','group_id='.sQ($student_data['group_id']));
$group_data=$group_data[0];

$prefix=$prefix_data[$student_data['gender_id']];
$studentName=$prefix.$student_data['stu_fname'].' '.$student_data['stu_lname'];

$subdistric_data=sSelectTb($systemDb,'subdistrict','*','subdistrict_code='.sQ($student_data['tumbol_id']));
$subdistric_data=$subdistric_data[0];

$distric_data=sSelectTb($systemDb,'district','*','district_code='.sQ($subdistric_data['district_code']));
$distric_data=$distric_data[0];

$province_data=sSelectTb($systemDb,'province','*','province_code='.sQ($subdistric_data['province_code']));
$province_data=$province_data[0];

   //$ret.='<div align="right">แบบ อวท.๑๐</div>';
   $ret.='<table width="100%">
   <tr>
   <td width="20%">
   </td>
      <td align="center">
         <img src="'.site_url('images/AOFTP_logo.jpg',true).'" width="100">
      </td>
      <td width="20%" valign="top" align="right">
      แบบ อวท. ๐๖
      </td>
   </tr>
   </table>';
   $ret.='<div align="center">
   <b>
      ใบสมัคร<br>
      สมาชิกชมรมวิชาชีพ...................................................................<br>
      องค์การนักวิชาชีพในอนาคตแห่งประเทศไทย<br>
      '.get_system_config('school_name').'
   </b>
   </div>';
   
   $ret.='<div align="right">
      องค์การนักวิชาชีพในอนาคตแห่งประเทศไทย<br>
      '.get_system_config('school_name').'
   </div>';
   
   $ret.='<div align="right">
      วันที่..............เดือน........................................พ.ศ....................
   </div>';
   $ret.='<table width="100%" style="">
      <tr>
      <td width="20%" align="right">
      '.$TAB.'ข้าพเจ้า
      </td>
      <td width="44%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$studentName.'
      </td>
      
      <td width="26%" align="right">
       เป็นนักเรียน นักศึกษา ระดับชั้น 
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$level_data[mb_substr($student_data['student_id'],2,1)].'
      </td>
      </tr>
      </table>
      
      <table width="100%" style="">
      <tr>
      <td width="5%" align="left">
      รหัส
      </td>
      <td width="22%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['student_id']).'
      </td>
      <td width="8%" align="right">
      สาขาวิชา
      </td>
      <td width="30%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$group_data['major_name'].'
      </td>
      <td width="5%" align="right">
      สาขางาน 
      </td>
      <td width="30%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$group_data['minor_name'].'
      </td>
      </tr>
      </table>
      
      <table width="100%" style="">
      <tr>
      <td width="40%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
      '.get_system_config('school_name').'
      </td>
      <td width="10%" align="right">
      เกิดวันที่ 
      </td>
      <td width="5%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum(mb_substr($student_data['birthday'],0,2)).'
      </td>
      <td width="5%" align="right">
      เดือน 
      </td>
      <td width="15%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$strMonthFull[(mb_substr($student_data['birthday'],3,2)+0)].'
      </td><td width="5%" align="right">
      พ.ศ. 
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum(($student_data['birthday']?mb_substr($student_data['birthday'],6,4)+0:'')).'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="10%" align="left">
      ที่อยู่ปัจจุบันบ้านเลขที่ 
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['home_id']).'
      </td>
      <td width="5%" align="right">
      ตรอก/ซอย 
      </td>
      <td width="14%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['alley']).'
      </td><td width="8%" align="right">
      ถนน/หมู่ที่
      </td>
      <td width="5%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['moo']).'
      </td>
      <td width="10%" align="right">
      แขวง/ตำบล
      </td>
      <td width="15%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$subdistric_data['subdistrict_name'].'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="10%" align="left">
      เขต/อำเภอ 
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$distric_data['district_name'].'
      </td>
      <td width="5%" align="right">
      จังหวัด
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$province_data['province_name'].'
      </td><td width="10%" align="right">
      รหัสไปรษณีย์
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($distric_data['postcode']).'
      </td>
      <td width="8%" align="right">
      โทรศัพท์
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['tele_number']).'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="10%" align="left">
      ชื่อบิดา 
      </td>
      <td width="40%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$student_data['fat_fname'].' '.$student_data['fat_lname'].'
      </td>
      <td width="10%" align="rigth">
      ชื่อมารดา 
      </td>
      <td width="40%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$student_data['mot_fname'].' '.$student_data['mot_lname'].'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="20%" align="left">
      ขอสมัครเป็นสมาชิกชมรมวิชาชีพ
      </td>
      <td width="80%" style="border-bottom: 1px solid black; border-style: dotted;">
      '.$TAB.'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="23%" align="left">
      องค์การนักวิชาชีพในอนาคตแห่งประเทศไทย
      </td>
      <td width="77%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
      '.get_system_config('school_name').'
      </td>
      </tr>
   </table>
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">&nbsp;</td>
      </tr>
   </table>
    
   <table width="100%" style="">
      <tr>
      <td width="50%">
      </td>
      <td width="50%" align="center">
      <br>
      ลงชื่อ.......................................................................ผู้สมัคร<br>
      ( '.$studentName.' )<br>
      </td>
      </tr>
   </table>
   
   
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">
      <b>บันทึกของนายทะเบียน</b>
      </td>
      </tr>
   </table>
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">
      '.$TAB.'ได้ตรวจสอบคุณสมบัติและการลงทะเบียนแล้ว [&nbsp;&nbsp;&nbsp;&nbsp;] เป็นไปตามระเบียบ  [&nbsp;&nbsp;&nbsp;&nbsp;] ไม่เป็นไปตามระเบียบ
      </td>
      </tr>
      <tr>
      <td width="100%" align="left">
      รับเป็นสมาชิก ณ วันที่............................เดือน................................................ พ.ศ. ............................
      </td>
      </tr>
      </table>
   
   <table width="100%" style="">
      <tr>
      <td width="50%">
      </td>
      <td width="50%" align="center">
      <br>
      <br>
      ลงชื่อ.......................................................................<br>
      (...................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
      นายทะเบียนชมรมวิชาชีพ................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </td>
      </tr>
   </table>
   ';
   
   return $ret;
}

function signUpFrom_10($code){
   
   global $strMonthFull;
   global $systemDb;
   $ret='';
  
   $prefix_data=array(
       '1'=>'นาย',
       '2'=>'นางสาว',
   );
   
   $level_data=array(
      '2'=>'ปวช. ',
      '3'=>'ปวส. ',
      '4'=>'ปวส. ',
   );

   $TAB='<span style="visibility:hidden;" style="color:white;">XXXXXXXXX.</span>';
   $student_data=sSelectTb($systemDb,'std','*','student_id='.sQ($code));
$student_data=$student_data[0];
$group_data=sSelectTb($systemDb,'group','*','group_id='.sQ($student_data['group_id']));
$group_data=$group_data[0];

$prefix=$prefix_data[$student_data['gender_id']];
$studentName=$prefix.$student_data['stu_fname'].' '.$student_data['stu_lname'];

$subdistric_data=sSelectTb($systemDb,'subdistrict','*','subdistrict_code='.sQ($student_data['tumbol_id']));
$subdistric_data=$subdistric_data[0];

$distric_data=sSelectTb($systemDb,'district','*','district_code='.sQ($subdistric_data['district_code']));
$distric_data=$distric_data[0];

$province_data=sSelectTb($systemDb,'province','*','province_code='.sQ($subdistric_data['province_code']));
$province_data=$province_data[0];

   //$ret.='<div align="right">แบบ อวท.๑๐</div>';
   $ret.='<table width="100%">
   <tr>
   <td width="20%">
   </td>
      <td align="center">
         <img src="'.site_url('images/AOFTP_logo.jpg',true).'" width="100">
      </td>
      <td width="20%" valign="top" align="right">
      แบบ อวท. ๑๐
      </td>
   </tr>
   </table>';
   $ret.='<div align="center">
   <b>
      ใบสมัคร<br>
      สมาชิกองค์การนักวิชาชีพในอนาคตแห่งประเทศไทย<br>
      '.get_system_config('school_name').'
   </b>
   </div>';
   
   $ret.='<div align="right">
      องค์การนักวิชาชีพในอนาคตแห่งประเทศไทย<br>
      '.get_system_config('school_name').'
   </div>';
   
   $ret.='<div align="right">
      วันที่..............เดือน........................................พ.ศ....................
   </div>';
   $ret.='<table width="100%" style="">
      <tr>
      <td width="20%" align="right">
      '.$TAB.'ข้าพเจ้า
      </td>
      <td width="44%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$studentName.'
      </td>
      
      <td width="26%" align="right">
       เป็นนักเรียน นักศึกษา ระดับชั้น 
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$level_data[mb_substr($student_data['student_id'],2,1)].'
      </td>
      </tr>
      </table>
      
      <table width="100%" style="">
      <tr>
      <td width="5%" align="left">
      รหัส
      </td>
      <td width="22%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['student_id']).'
      </td>
      <td width="8%" align="right">
      สาขาวิชา
      </td>
      <td width="30%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$group_data['major_name'].'
      </td>
      <td width="5%" align="right">
      สาขางาน 
      </td>
      <td width="30%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$group_data['minor_name'].'
      </td>
      </tr>
      </table>
      
      <table width="100%" style="">
      <tr>
      <td width="40%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
      '.get_system_config('school_name').'
      </td>
      <td width="10%" align="right">
      เกิดวันที่ 
      </td>
      <td width="5%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum(mb_substr($student_data['birthday'],0,2)).'
      </td>
      <td width="5%" align="right">
      เดือน 
      </td>
      <td width="15%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$strMonthFull[(mb_substr($student_data['birthday'],3,2)+0)].'
      </td><td width="5%" align="right">
      พ.ศ. 
      </td>
      <td width="15%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum(($student_data['birthday']?mb_substr($student_data['birthday'],6,4)+0:'')).'
      </td>
      <td width="10%" align="right">
      &nbsp;
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="20%" align="right">
      ที่อยู่ปัจจุบันบ้านเลขที่ 
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['home_id']).'
      </td>
      <td width="5%" align="right">
      ตรอก/ซอย 
      </td>
      <td width="14%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['alley']).'
      </td><td width="8%" align="right">
      ถนน/หมู่ที่
      </td>
      <td width="5%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['moo']).'
      </td>
      <td width="10%" align="right">
      แขวง/ตำบล
      </td>
      <td width="15%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$subdistric_data['subdistrict_name'].'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="10%" align="left">
      เขต/อำเภอ 
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$distric_data['district_name'].'
      </td>
      <td width="5%" align="right">
      จังหวัด
      </td>
      <td width="20%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.$province_data['province_name'].'
      </td><td width="10%" align="right">
      รหัสไปรษณีย์
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($distric_data['postcode']).'
      </td>
      <td width="8%" align="right">
      โทรศัพท์
      </td>
      <td width="10%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
       '.thaiNum($student_data['tele_number']).'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="6%" align="left">
      ชื่อบิดา 
      </td>
      <td width="44%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$student_data['fat_fname'].' '.$student_data['fat_lname'].'
      </td>
      <td width="6%" align="rigth">
      ชื่อมารดา 
      </td>
      <td width="44%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$student_data['mot_fname'].' '.$student_data['mot_lname'].'
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="60%" align="left">
      ขอสมัครเป็นสมาชิกชมรมวิชาชีพองค์การนักวิชาชีพในอนาคตแห่งประเทศไทย
      </td>
      <td width="40%" style="border-bottom: 1px solid black; border-style: dotted;" align="center">
      '.get_system_config('school_name').'
      </td>
      </tr>
   </table>
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">&nbsp;</td>
      </tr>
   </table>

    
   <table width="100%" style="">
      <tr>
      <td width="50%">
      </td>
      <td width="50%" align="center">
      <br>
      ลงชื่อ.......................................................................ผู้สมัคร<br>
      ( '.$studentName.' )<br>
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">
      <b>บันทึกของเจ้าหน้าที่</b> ระดับสมาชิก
      </td>
      </tr>
   </table>
   <table width="100%" style="">
      <tr>
      <td width="100%" align="left">
      '.$TAB.'&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] สมาชิกสามัญ&nbsp;&nbsp;ระดับสถานศึกษา<br>'.$TAB.'ทะเบียนเลขที่........................................ เมื่อวันที่ ......... เดือน ................... พ.ศ. ....................
      </td>
      </tr>
      <tr>
      <td width="100%" align="left">
      '.$TAB.'&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] สมาชิกสามัญ&nbsp;&nbsp;ระดับจังหวัด<br>'.$TAB.'ทะเบียนเลขที่........................................ เมื่อวันที่ ......... เดือน ................... พ.ศ. ....................
      </td>
      </tr>
      </tr>
      <tr>
      <td width="100%" align="left">
      '.$TAB.'&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] สมาชิกสามัญ&nbsp;&nbsp;ระดับภาค<br>'.$TAB.'ทะเบียนเลขที่........................................ เมื่อวันที่ ......... เดือน ................... พ.ศ. ....................
      </td>
      </tr>
      </tr>
      <tr>
      <td width="100%" align="left">
      '.$TAB.'&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] สมาชิกสามัญ&nbsp;&nbsp;ระดับชาติ<br>'.$TAB.'ทะเบียนเลขที่........................................ เมื่อวันที่ ......... เดือน ................... พ.ศ. ....................
      </td>
      </tr>
      <tr>
      <td width="100%" align="left">
      '.$TAB.'&nbsp;&nbsp;[&nbsp;&nbsp;&nbsp;&nbsp;] สมาชิกวิสามัญ<br>'.$TAB.'ทะเบียนเลขที่........................................ เมื่อวันที่ ......... เดือน ................... พ.ศ. ....................
      </td>
      </tr>
   </table>
   
   <table width="100%" style="">
      <tr>
      <td width="50%">
      </td>
      <td width="50%" align="center">
      <br>
      ลงชื่อ.......................................................................นายทะเบียนองค์การ<br>
      (...................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
      </td>
      </tr>
   </table>
   
   ';
   
   return $ret;
}
