<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
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

                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
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

            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
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

            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
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
    var totalStudent=0;
    var totalStep=0;
    var currentStep=0;
    var tranfered=0;
    var countPerStep=100;
        $("#studentTransfer").click(function(){
            $("#ajaxResponseStudent").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/studentTransfer/total_student').'",function(data){
                var student=JSON.parse(data);
                totalStudent=student.student_count;
                totalStep=Math.ceil(student.student_count/countPerStep);
                $("#ajaxResponseStudent").text("กำลังโอนข้อมูลผู้เรียน 0/"+totalStudent+" คน");
                transferStudent();

            });
            
        });

        function transferStudent(){
            $.get("'.site_url('ajax/admin/studentTransfer/transfer_student/step/').'"+currentStep+"/limit/"+countPerStep,function(data){
                var res=JSON.parse(data);
                tranfered+=res.transfered;
                currentStep++;
                $("#ajaxResponseStudent").text("กำลังโอนข้อมูลผู้เรียน "+(tranfered)+"/"+totalStudent+" คน");
                if(tranfered<totalStudent){
                    transferStudent();
                }else{
                    std_grouping();
                }

            });

        }
        function std_grouping(){
            $.get("'.site_url('ajax/admin/studentTransfer/student_group').'",function(data){
                $("#ajaxResponseStudent").text(data);

            });
        }

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
