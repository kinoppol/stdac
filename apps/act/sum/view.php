<?php
$current_semester=get_system_config("current_semester");
?>
<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>กลุ่มผู้เรียน</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php print site_url('main/act/transaction/view'); ?>">ดูทั้งหมด</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                        <form method="post">
                        <?php
                            //print_r($_POST);
                        ?>
    ภาคเรียนปัจจุบัน <?php print $current_semester; ?>
</form>
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
                    $('#grouptable').load('".site_url('ajax/act/sum/group_table')."');
                }
                </script>";