<?php
$import_student=0;
sDeleteTb($systemDb,"semester");
//print "Hello";
$rms=get_system_config("rms_url");
$semester_data=rms_get_data($rms,'nutty','dateedu');

//print_r($semester_data);

$insertSemester=0;
foreach($semester_data as $row){
    $data=array(
        'semester_start'=>sQ($row['dateedu_start']),
        'semester_end'=>sQ($row['dateedu_end']),
        'semester_eduyear'=>sQ($row['dateedu_eduyear']),
        'datechk_end'=>sQ($row['datechk_end']),
    );
    $result=sInsertTb($systemDb,'semester',$data);
    
    if($result) $insertSemester++;
}

print "นำเข้าข้อมูลภาคเรียนจำนวน ".$insertSemester." ภาคเรียน";