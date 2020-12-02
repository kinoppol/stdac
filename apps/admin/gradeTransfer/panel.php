<?php
$current_semester=get_system_config("current_semester");
$semesterData=sSelectTb($systemDb,'semester','semester_eduyear','1 order by semester_start desc');
$semesters=array();
foreach($semesterData as $row){
    $semesters[$row['semester_eduyear']]=$row['semester_eduyear'];
}
?><div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">

                            <h2>โอนข้อมูลผลกิจกรรม</h2>
                        </div>
                        <div class="body">
                        <div id="ajaxResponse"></div>
                        เลือกภาคเรียน <select id="selectedSemester">
                            <?php
                                print gen_option($semesters,$current_semester);
                            ?>
                        </select>
                            <button class="btn btn-lg btn-primary" id="transfer">โอนข้อมูล</button>
                        </div>
                    </div>
                </div>
    </div>
<?php
$systemFoot.='
    <script>
        $("#transfer").click(function(){
            var semester=$("#selectedSemester").val();
            semester=semester.replace("/","-");
            //alert(encodeURIComponent(semester));
            $("#ajaxResponse").text("กำลังโหลดโปรดรอสักครู่...");
            $.get("'.site_url('ajax/admin/gradeTransfer/rms/semester/').'"+semester,function(data){
                $("#ajaxResponse").text(data);
            });
            
        });
    </script>';
