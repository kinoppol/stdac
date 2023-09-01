<?php
$rms=get_system_config("rms_url");
$group_data=rms_get_data($rms,'nutty','student_group',null,null);
sDeleteTb($systemDb,"group");
$import_group=0;
foreach($group_data as $group){
    if($group['student_group_hidden']==0){//0=คือสถานะที่นักเรียนกำลังเรียนอยู่
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
}

print "นำเข้าข้อมูลผู้เรียน ".$import_group." กลุ่ม";