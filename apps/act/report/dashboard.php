<?php
    $title="ภาพรวม";

    $current_semester=get_system_config("current_semester");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>
  <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD (<?php print $current_semester; ?>)</h2>
            </div>

            <?php
            $current_edu_year=mb_substr($current_semester,2,4);
            $current_semester=mb_substr($current_semester,0,1);


                    $act_amount=sSelectTb($systemDb,'activity','count(*) as c','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year));
                    $act_amount=$act_amount[0];

                    $past_act_amount=sSelectTb($systemDb,'activity','count(*) as c','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' AND end_time<NOW()');
                    $past_act_amount=$past_act_amount[0];                  

                    $now_act_amount=sSelectTb($systemDb,'activity','count(*) as c','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' AND start_time<NOW() AND end_time>NOW()');
                    $now_act_amount=$now_act_amount[0];
                                 
                    $future_act_amount=sSelectTb($systemDb,'activity','count(*) as c','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' AND start_time>NOW()');
                    $future_act_amount=$future_act_amount[0];
                ?>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <a href="<?php print site_url("main/wallet/transaction/view"); ?>">
                            <i class="material-icons">description</i>
                            </a>
                        </div>
                        
                        <div class="content">
                            <div class="text">จำนวนกิจกรรมทั้งหมด</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $act_amount['c'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                        
                    </div>
                </div>

                <?php
/*
                    $picCount=sSelectTb($systemDb,'files_doc','count(*) as c','owner_id='.current_user('id').' AND type="pic"',true);
                    $picCount=$picCount[0];
    */
                ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                        <a href="<?php print site_url("main/upload_file/manage/view/type/pic"); ?>">
                            <i class="material-icons">done_all</i>
                        </a>
                        </div>
                        <div class="content">
                            <div class="text">กิจกรรมที่ดำเนินการแล้ว</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $past_act_amount['c']; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
                <?php
/*
                    $docCount=sSelectTb($systemDb,'files_doc','count(*) as c','owner_id='.current_user('id').' AND type="doc"');
                    $docCount=$docCount[0];
*/
                ?>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                        <a href="<?php print site_url("main/upload_file/manage/view/type/doc"); ?>">
                            <i class="material-icons">rotate_left</i>
                            </a>
                        </div>
                        <div class="content">
                            <div class="text">กิจกรรมที่กำลังดำเนินการ</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $now_act_amount['c']; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">                        
                        <a href="<?php print site_url("main/upload_file/manage/view"); ?>">
                            <i class="material-icons">alarm</i>
                        </a>
                        </div>
                        <div class="content">
                            <div class="text">กิจกรรมที่กำลังมาถึง</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $future_act_amount['c']; ?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>สรุปผลกิจกรรม</h2>
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
                            <div id="act_summary">
                            <?php
                                $genReport_btn=array(
                                    'id'=>'genReport',
                                    'onlyClickClose'=>false,
                                    'src'=>site_url('ajax/act/report/wizard'),
                                );
                            ?>
                                <a <?php print gen_modal_link($genReport_btn); ?> class="btn bg-red"><i class="material-icons">picture_as_pdf</i> สร้างรายงาน</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

                $data_modal=array(
                    'id'=>'genReport',
                    'title'=>'สร้างรายงาน',
                );

                
                print gen_modal($data_modal);
                ?>
                <!-- #END# Task Info -->
                <!-- Disk Usage -->
                <?php
/*
                    $docSize=sSelectTb($systemDb,'files_doc','sum(file_size) as c','owner_id='.current_user('id').' AND type="doc"');
                    $docSize=$docSize[0];
                    
                    $picSize=sSelectTb($systemDb,'files_doc','sum(file_size) as c','owner_id='.current_user('id').' AND type="pic"');
                    $picSize=$picSize[0];

                    $totalSize=100*1024*1024;
                    $freeSize=$totalSize-$docSize['c']-$picSize['c'];
*/
                ?><!--
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="header">
                            <h2>พื้นที่เก็บข้อมูล <?php print formatSizeUnits($totalSize); ?></h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php print site_url('main/upload_file/manage/view'); ?>">จัดการไฟล์</a></li>
                                        <li><a href="javascript:void(0);">เพิ่มพื้นที่</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="donut_chart" class="dashboard-donut-chart"></div>
                        </div>
                    </div>
                </div>-->
                <!-- #END# Disk Usage -->
               
            </div>
            <?php
/*
            $systemFoot.="<script>
            $(function(){
                load_last_transaction();
            });
                function load_last_transaction(){
                    $('#last_transaction').load('".site_url('ajax/home/dashboard/last_transaction')."');
                }
            </script>";
            $systemFoot.="
            <script>
            $(function(){
                initDonutChart();
            });
                function initDonutChart() {
    Morris.Donut({
        element: 'donut_chart',
        data: [{
            label: 'เอกสาร (".formatSizeUnits($docSize['c']).")',
            value: ".round($docSize['c']/$totalSize*100)."
        }, {
            label: 'รูปภาพ (".formatSizeUnits($picSize['c']).")',
            value: ".round($picSize['c']/$totalSize*100)."
        }, {
            label: 'ว่าง (".formatSizeUnits($freeSize).")',
            value: ".round($freeSize/$totalSize*100)."
        },],
        colors: ['rgb(212, 50,50)', 'rgb(50, 180, 50)', 'rgb(0, 152, 212)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'],
        formatter: function (y) {
            return y + '%'
        }
    });
}
            </script>
            ";
*/
