<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>กลุ่มผู้เรียน</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a> 
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php print site_url('main/wallet/transaction/view'); ?>">ดูทั้งหมด</a></li>
                                    </ul>-->
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="grouptable">
                            โปรดรอสักครู่..
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<?php
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

$data_modal=array(
    'id'=>'optionCheck',
    'title'=>'ตัวเลือกการเช็คชื่อ',
);


print gen_modal($data_modal);

$systemFoot.="<script>
            $(function(){
                load_group();
            });
                function load_group(){
                    $('#grouptable').load('".site_url('ajax/act/assembly/group_table')."');
                }
                </script>";