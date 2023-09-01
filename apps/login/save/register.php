<?php
//print_r($_POST);
    $data=array(
        'firstname'=>sQ($_POST['firstname']),
        'lastname'=>sQ($_POST['lastname']),
        'email'=>sQ($_POST['email']),
        'password'=>sQ(md5($_POST['password'])),
        'school_id'=>sQ($_POST['school_id']),
    );
$result=sInsertTb($systemDb,'user_data',$data);
if(!$result){
    print '
    โปรดรอสักครู่
    <script>
    alert("Error ไม่สามารถลงทะเบียนได้ '.$systemDb['db']->error.'");
    </script>';
    redirect(site_url(),true,5);
    exit();
}
?>
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
?>"><h1>ขอแสดงความยินดีด้วย</h1><span>ท่านได้ทำการลงทะเบียนเรียบร้อยแล้ว</span></div>
<div class="card-body">
<div class="row"><div class="col">
<div style="text-align:center">
    <a class="btn btn-primary" href="<?php
print site_url('authen/login/form/regular');
?>">ลงชื่อเข้าใช้</a>
    </div>
</div>
</div>
</div>
<div class="card-footer"><p class="text-muted">ระบบครูพิเศษ EEC</p>
</div></div></div></div><script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script><script src="<?php print $theme_URL; ?>/dist/admin4b.min.js"></script><script src="<?php print $theme_URL; ?>/docs/assets/js/docs.js"></script></body>