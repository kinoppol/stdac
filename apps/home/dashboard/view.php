<?php
    $title="ภาพรวม";
?>
  <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <?php


                    $activity_amount=sSelectTb($systemDb,'activity','count(*) as c');
                    $activity_amount=$activity_amount[0];
                ?>
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <a href="<?php print site_url("main/act/view/list"); ?>">
                            <i class="material-icons">description</i>
                            </a>
                        </div>
                        
                        <div class="content">
                            <div class="text">จำนวนกิจกรรมทั้งหมด</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $activity_amount['c'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                        
                    </div>
                </div>

                <?php
                    $std_amount=sSelectTb($systemDb,'std','count(*) as c');
                    $std_amount=$std_amount[0];
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                        <a href="<?php print site_url("main/admin/managestudent/list"); ?>">
                            <i class="material-icons">supervisor_account</i>
                        </a>
                        </div>
                        <div class="content">
                            <div class="text">จำนวนนักเรียนทั้งหมด</div>
                            <div class="number count-to" data-from="0" data-to="<?php print $std_amount['c'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                
                <?php
                    //$docCount=sSelectTb($systemDb,'files_doc','count(*) as c','owner_id='.current_user('id').' AND type="doc"');
                    //$docCount=$docCount[0];
                ?>
                
               

                </div>
            </div>
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>กิจกรรมล่าสุด</h2>
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
                            <div id="last_transaction">
                            </div>
                        </div>
                    </div>
                </div>
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
                ?>
          
            </div>