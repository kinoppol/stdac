<?php
$theme_URL=site_url("system/template/admin4b/src",true);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script><script src="<?php print $theme_URL; ?>/dist/admin4b.min.js"></script><script src="<?php print $theme_URL; ?>/docs/assets/js/docs.js"></script>
<style>
.page-sign.sign-up {
  background:
    linear-gradient(-160deg, rgba(60, 162, 224, .25) 50%, rgba(241, 244, 245, .9) 50%),
    url("<?php print site_url('images/bg.jpg',true); ?>");
}
    </style>
<body><div class="page-sign sign-up"><div class="container pb-0 mb-0">
</div><div class="container-sign"><div class="card"><div class="card-header">
<img src="<?php
print site_url('images/eec.png',true);
?>"><h1>ยินดีต้อนรับ</h1><span>การลงทะเบียนเพื่อใช้งานระบบ</span></div>

<?php
load_fun('table');
load_fun('datatable');

$schoolData=array();
$school_data=sSelectTb($systemDb,'school_data','*');
foreach($school_data as $row){
$selectLink='<a href="'.site_url("authen/login/form/register/sid/".$row['school_id']).'"
 class="btn btn-primary" title="เลือก">
      <i class="fa fa-university"></i>
      </a>';
    $schoolData[]=array(
            //$row['school_id'],
            $row['school_name'],
            $selectLink,
        );
    //$linkArr['uri'][]=$row['group_id'];
}	

//print_r($schoolData);
        $data=array("head"=>array(
        //'รหัสสถานศึกษา',
        'ชื่อสถานศึกษา',
        'เลือก',
        ),
        'id'=>'school',
        'item'=>$schoolData,
        'pagelength'=>10,
        'order'=>'[[ 0, "asc" ]]'
        );
        print datatable($data);

?>
<div class="card-footer"><p class="text-muted">หากท่านได้เคยลงทะเบียนแล้ว?</p><a href="<?php
print site_url('authen/login/form/regular');
?>">ลงชื่อเข้าใช้</a></div></div></div></div></body>
