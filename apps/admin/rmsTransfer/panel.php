<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลผู้เรียน</h2>
                        </div>
                        <div class="body">
                        <div id="ajaxResponseStudent"></div>
                            <button class="btn btn-lg btn-primary btn-block" id="studentTransfer"><i class="material-icons">people</i>โอนข้อมูลผู้เรียน</button>
                        </div>
                    </div>
                </div>
    </div>

    <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลบุคลากร</h2>
                        </div>
                        <div class="body">
                        <div id="ajaxResponsePeople"></div>
                            <button class="btn btn-lg btn-primary btn-block" id="peopleTransfer"><i class="material-icons">assignment_ind</i> โอนข้อมูลบุคลากร</button>
                        </div>
                    </div>
                </div>
    </div>

<div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2>โอนข้อมูลภาคเรียน</h2>
                    </div>
                    <div class="body">
                    <div id="ajaxResponseSemester"></div>
                        <button class="btn btn-lg btn-primary btn-block" id="semesterTransfer"><i class="material-icons">schedule</i> โอนข้อมูลภาคเรียน</button>
                    </div>
                </div>
            </div>
</div>

<div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="header">
                        <h2>โอนข้อมูลวันหยุดจากระบบ RMS</h2>
                    </div>
                    <div class="body">
                    <div id="ajaxResponseHoliday"></div>
                        <button class="btn btn-lg btn-primary btn-block" id="holidayTransfer"><i class="material-icons">schedule</i> โอนข้อมูลวันหยุดจากระบบ RMS</button>
                    </div>
                </div>
            </div>
</div>

<?php
$systemFoot.='
    <script>
        $("#studentTransfer").click(function(){
            $("#ajaxResponseStudent").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/studentTransfer/student').'",function(data){
                $("#ajaxResponseStudent").text(data);
            });
            
        });

        $("#peopleTransfer").click(function(){
            $("#ajaxResponsePeople").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/peopleTransfer/people').'",function(data){
                $("#ajaxResponsePeople").text(data);
            });
            
        });

        $("#semesterTransfer").click(function(){
            $("#ajaxResponseSemester").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/semesterTransfer/semester').'",function(data){
                $("#ajaxResponseSemester").text(data);
            });
            
        });
        $("#holidayTransfer").click(function(){
            $("#ajaxResponseHoliday").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/holidayTransfer/holidayRMS').'",function(data){
                $("#ajaxResponseHoliday").text(data);
            });
            
        });
    </script>';
