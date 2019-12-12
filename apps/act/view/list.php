<?php

    if($hGET['action']=='delete'&&$hGET['id']!=''){
        sDeleteTb($systemDb,'activity','id='.$hGET['id']);
    }

?>
 <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>กิจกรรม</h2>
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
                        <?php
                            if(current_user('user_type')=='admin'||current_user('user_type')=='staff'){
                        ?>
                        <div id="display_btn">
                        <a <?php

                        
$data_link=array(
    'id'=>'addAc',
    'onlyClickClose'=>true,
    'src'=>site_url('ajax/act/add_ac/form'),
);

                            print gen_modal_link($data_link);
                        ?> class="btn btn-primary"><i class="material-icons">library_add</i> เพิ่มกิจกรรม</a>
                            </div>
                            <?php
                            }
                            ?>
                            <div id="actable">
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<?php

$data_modal=array(
    'id'=>'addAc',
    'title'=>'เพิ่มกิจกรรม',
);

print gen_modal($data_modal);

$data_modal=array(
    'id'=>'editAc',
    'title'=>'แก้ไขกิจกรรม',
);

print gen_modal($data_modal);

$data_modal=array(
    'id'=>'groupAc',
    'title'=>'เลือกกลุ่มผู้เรียน',
    'onClose'=>'load_ac();',
);

print gen_modal($data_modal);

$data_modal=array(
    'id'=>'checkAc',
    'title'=>'เช็คชื่อเข้าร่วมกิจกรรม',
);

print gen_modal($data_modal);

$data_modal=array(
    'id'=>'reportAc',
    'title'=>'รายงาน',
);

print gen_modal($data_modal);

$systemFoot.="<script>
            $(function(){
                load_ac();
            });
                function load_ac(){
                    $('#actable').load('".site_url('ajax/act/list/ac_table')."');
                }
                </script>";