<?php
$rms=get_system_config("rms_url");
$people_data=rms_get_data($rms,'nutty','people');
$people_pro_data=rms_get_data($rms,'nutty','people_pro');
$people_pro=array();
foreach($people_pro_data as $row){
    $people_pro[$row['people_id']]=$row['people_stagov_id'];
}
//print_r($people_data);
sDeleteTb($systemDb,"userdata");
$import_people=0;
foreach($people_data as $people){
    if(!isset($people_pro[$people['people_id']])||$people_pro[$people['people_id']]==88)continue;
    if($people['useradmin_activity']==1){//1 เฉพาะงานกิจกรรม

        $user_type="admin";
    }else{
        $user_type="user";
    }
    $data=array(
        "people_id"=>sQ($people['people_id']),
        "username"=>sQ($people['people_user']),
        "password"=>sQ($people['people_pass']),
        "name"=>sQ($people['people_name']),
        "surname"=>sQ($people['people_surname']),
        "image_uri"=>sQ($people['people_pic']),
        "user_type"=>sQ($user_type),
        "active"=>sQ($people['people_exit']==0?'Y':'N')
    );

    $chk_user=sSelectTb($systemDb,"userdata","count(*) as c",'people_id='.sQ($people['people_id']));
    $chk_user=$chk_user[0];
    if($chk_user['c']<1){
        $result=sInsertTb($systemDb,"userdata",$data);
    }else{
        $result=sUpdateTb($systemDb,"userdata",$data,'people_id='.sQ($people['people_id']));
    }
    //print_r($result);
    if($result){
        $import_people++;
        //print "1".$people['people_user'];
    }else{
        print $systemDb['db']->error;
        exit();
    }

}

?>
<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลเรียบร้อยแล้ว</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php print site_url('main/wallet/transaction/view'); ?>">ดูทั้งหมด</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            ข้อมูลบุคลากรจำนวน <?php print number_format($import_people);?> คน
                        </div>
                    </div>
                </div>
    </div>