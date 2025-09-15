<?php
//error_reporting(0);
load_fun('mpdf');
$group_id=$hGET['gid'];
//$stdDb=stdDb();\
$html='';
$student_data=sSelectTb($systemDb,'std','*','group_id='.sQ($group_id,true).' order by student_id');
$prefix_data=array(
    '1'=>'นาย',
    '2'=>'นางสาว',
);      
$html.=afp_17($student_data);

//print $html;
$pdf_data=array(
        			   'html'=>$html,
        			   'size'=>'A4',
        			   'fontsize'=>16,
        			   'marginL'=>20,
        			   'marginR'=>20,
        			   'marginT'=>0,
        			   'marginB'=>0,
        			   //'wartermarkimage'=>'https://sas.bncc.ac.th/images/bg.jpg',
        			   );
        			   
genPdf($pdf_data,$pageNo=NULL,$location=$dir,$fname);