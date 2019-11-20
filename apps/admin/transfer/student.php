<?php
$rms = new pSql(NULL,'http://rms.bncc.ac.th/api/psql.php');

$query='select student_id,perfix_id,stu_fname,stu_lname,group_id  from student where status=0';
$student_data=$rms->query($query);
//print_r($student_data);
sDeleteTb($systemDb,"std");
$import_student=0;
foreach($student_data['result'] as $student){
    $data=array(
        "student_id"=>sQ($student['student_id']),
        "prefix_id"=>sQ($student['perfix_id']),
        "stu_fname"=>sQ($student['stu_fname']),
        "stu_lname"=>sQ($student['stu_lname']),
        "group_id"=>sQ($student['group_id']),
    );
    $result=sInsertTb($systemDb,"std",$data);
    //print_r($result);
    if($result){
        $import_student++;
        //print "1";
    }
}

$query='SELECT * FROM `student_group` WHERE student_group_id in (
    select distinct group_id from student where status=0
    )';
$group_data=$rms->query($query);
sDeleteTb($systemDb,"group");
$import_group=0;
foreach($group_data['result'] as $group){
    $data=array(
        "group_id"=>sQ($group['student_group_id']),
        "group_short_name"=>sQ($group['student_group_short_name']),
        "major_name"=>sQ($group['major_name']),
        "minor_name"=>sQ($group['minor_name']),
        "level_name"=>sQ($group['level_name']),
    );
    $result=sInsertTb($systemDb,"group",$data);
    if($result){
        $import_group++;
    }
}
?>
<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>โอนข้อมูลเรียบร้อยแล้ว</h2>
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
                            ข้อมูลผู้เรียนจำนวน <?php print number_format($import_student);?> คน
                        </div>
                    </div>
                </div>
    </div>