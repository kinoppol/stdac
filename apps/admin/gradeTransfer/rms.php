<?php

$app_name='nutty';
$act_id=1;
$url_callback=site_url('ajax/admin/api/rms');

$URL=get_system_config("rms_url").'/api_connection.php?app_name='.$app_name.'&act_id='.$act_id.'&url='.urlencode($url_callback);
$result = file_get_contents($URL);
?>

<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลผลกิจกรรม</h2>
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
                            URL <?php print $URL; ?><br>
                            Callback URL <?php print $url_callback; ?><br>
                            ผลลัพธ์ <?php print $result;?>
                        </div>
                    </div>
                </div>
    </div>