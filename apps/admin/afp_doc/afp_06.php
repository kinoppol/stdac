<?php
error_reporting(0);
load_fun('mpdf');
$group_id=$hGET['gid'];
//$stdDb=stdDb();\
$html='';
$student_data=sSelectTb($systemDb,'std','*','group_id='.sQ($group_id,true).' order by student_id');
foreach($student_data as $std){
      
if(isset($type)&&$type=='full'){
   $oneForm=signUpFrom_06($std['student_id'],true);
}else{
   $oneForm=signUpFrom_06($std['student_id'],true);
}
   if($html!=''&&$oneForm)$html.="<PAGEBREAK>";
$html.=$oneCard;
$html.=signUpFrom_06($std['student_id']);
}
//print $html;
$pdf_data=array(
        			   'html'=>$html,
        			   'size'=>'A4',
        			   'fontsize'=>14,
        			   'marginL'=>20,
        			   'marginR'=>20,
        			   'marginT'=>20,
        			   'marginB'=>0,
        			   //'wartermarkimage'=>'https://sas.bncc.ac.th/images/bg.jpg',
        			   );
        			   
genPdf($pdf_data,$pageNo=NULL,$location=$dir,$fname);