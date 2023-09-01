<?php
function head_doc($param){
   $attach='';
   
   if($param['attach_name']!=''){
      $attach='<table width="100%">
   <tr>
   <td width="15%" style="vertical-align:top;">
   <b>
   สิ่งที่ส่งมาด้วย
   </b>
   </td>
   <td width="85%">
   '.$param['attach_name'].'</td>
   </tr>
   </table>
   ';
   }
   
   $ret='
   <table width="100%">
      <tr>
      <td width="10%">
      <img src="images/garuda.jpg" width="50" hieght="50">
      </td><td width="80%" style="vertical-align:bottom;"><center><h2>บันทึกข้อความ
      </h2></center></td>
      <td width="10%">
      </td>
      </tr>
   </table>
   <table width="100%" style="">
      <tr>
      <td width="10%">
      <b>ส่วนราชการ</b>
      </td>
      <td width="90%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$param['org'].'
      </h3>
      </td>
      </tr>
   </table>
   <table width="100%">
      <tr>
      <td width="3%">
      <b>ที่</b>
      </td>
      <td width="47%" style="border-bottom: 1px solid black; border-style: dotted;">
      '.$param['org_prefix'].'/'.($param['book_number']?$param['book_number']:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').'
      /'.thaiNum(date('Y')+543).'
      </td>
      <td width="5%">
      <b>วันที่</b>
      </td>
      <td width="45%" style="border-bottom: 1px solid black; border-style: dotted;">
       '.$param['book_date'].'
      </td>
      </tr>
      </table>
   <table width="100%" style="padding-bottom:5px;">
      <tr>
      <td width="5%">
      <b>เรื่อง</b></td>
      <td width="95%" style="border-bottom: 1px solid black; border-style: dotted;">
      '.$param['subject'].'
      </h3>
      </td>
      </tr>
   </table>
    <table width="100%">
   <tr>
   <td width="5%" style="vertical-align:top;">
   <b>
   เรียน
   </b>
   </td>
   <td width="95%">
   '.$param['to'].'</td>
   </tr>
   </table>
   ';//.$attach;
   return $ret;
}