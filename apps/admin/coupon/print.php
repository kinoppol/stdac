<?php
$dir='coupon/';
$fname=time().'.pdf';

$amount=20; //มูลค่าคูปอง
$coupon_num=10;// จำนวนคูปอง

$print_date=date("Y-m-d");
$exp_date=date("Y-m-d",strtotime("+365 days",time()));

if(current_user('user_type')!='admin'){
    print "คุณไม่มีสิทธิเข้าถึงส่วนนี้";
    exit();
}

load_fun('mpdf');


$html="<table width=100% border=1 celspacing=0 style='border: 1px solid black;border-collapse: collapse;'>";

for($i=1;$i<=$coupon_num;$i++){
    $password= str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

    $data=array(
        'password'=>sQ(md5($password)),
        'create_time'=>'NOW()',
        'amount'=>$amount,
        'expire_time'=>sQ($exp_date),
    );

    $result=sInsertTb($systemDb,'coupon',$data);

    $last_id=mysqli_insert_id($systemDb['db']);

    $html.="<tr>
    <td style='text-align:center' colspan='4'>&nbsp;</td>
    <td style='text-align:center'>////</td><td style='text-align:center' colspan='2'> พิมพ์วันที่ ".$print_date."</td>
    </tr>
    <tr>
    <td style='text-align:center' width='15%'>COUPON ID</td>
    <td style='text-align:center' width='15%'>".str_pad($last_id, 8, '0', STR_PAD_LEFT)."</td>
    <td style='text-align:center' width='15%'>PASSWORD</td>
    <td style='text-align:center' width='15%'>".$password."</td>
    <td style='text-align:center' width='5%'>////</td>
    <td style='text-align:center' width='15%'>คูปองราคา</td>
    <td style='text-align:center' width='15%'><strong>".$amount." บาท</strong></td>
    </tr>
    <tr>
    <td style='text-align:center' colspan='4'>&nbsp;</td>
    <td style='text-align:center'>////</td><td style='text-align:center' colspan='2'> วันหมดอายุ ".$exp_date." </td>
    </tr>";

}
$html.="</table>";

$pdf_data=array(
    'html'=>$html,
    'size'=>"A4",
    'fontsize'=>18,
    'marginL'=>20,
    'marginR'=>10,
    'marginT'=>10,
    'marginB'=>10,
    'footer'=>'This document was created by printStation system of information centre at bangna commercial college. '.date('Y-m-d H:i:s'),
    //'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
);
//print $html;
genPdf($pdf_data,$pageNo=NULL,$location=$dir,$fname);
//print $html;
redirect(site_url($dir.$fname,true));