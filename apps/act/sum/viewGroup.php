<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>รหัสกลุ่ม <?php print $hGET['group_id']?></h2>
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
                            <div id="grouptable">
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<?php


$systemFoot.="<script>
            $(function(){
                load_group();
            });
                function load_group(){
                    $('#grouptable').load('".site_url('ajax/act/sum/student_table')."/group/".$hGET['group_id']."');
                }
                </script>";