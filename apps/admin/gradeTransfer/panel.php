<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลผลกิจกรรม</h2>
                        </div>
                        <div class="body">
                        <div id="ajaxResponse"></div>
                            <button class="btn btn-lg btn-primary" id="transfer">โอนข้อมูล</button>
                        </div>
                    </div>
                </div>
    </div>
<?php
$systemFoot.='
    <script>
        $("#transfer").click(function(){
            $("#ajaxResponse").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/gradeTransfer/rms').'",function(data){
                $("#ajaxResponse").text(data);
            });
            
        });
    </script>';
