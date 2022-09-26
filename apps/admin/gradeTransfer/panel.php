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
                    <div class="card col-md-8">
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
                            <br>
                            <button class="btn btn-lg btn-primary form-control" id="evaluate">ประมวลผล</button>
                            <br>
                            <button class="btn btn-lg btn-danger form-control" id="transfer" disabled>โอนข้อมูล</button>
                        </div>
                    </div>
                </div>
    </div>
<?php
$systemFoot.='
<script>
        $("#evaluate").click(function(){
            var semester=$("#selectedSemester").val();
            var round=0;
            //var loop=true;
            semester=semester.replace("/","-");
            //alert(encodeURIComponent(semester));
            $("#ajaxResponse").text("กำลังโหลดโปรดรอสักครู่...");
            $("#evaluate").attr("disabled",true);
            eva(semester,0);
            
        });
        function eva(semester,round){
            $.get("'.site_url('ajax/admin/gradeTransfer/group_evaluate/semester/').'"+semester+"/round/"+round,function(data){
                if(data.trim()=="ok"){
                    //exit
                    eva_complete();
                }else{
                    eva(semester,round+1);
                }
                $("#ajaxResponse").text(data);
            });
        }
        function eva_complete(){
            $("#ajaxResponse").text("ประมวลผลสำเร็จ");
            $("#transfer").removeAttr("disabled");
        }
    </script>
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
