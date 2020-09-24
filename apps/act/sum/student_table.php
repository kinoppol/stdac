<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$current_semester=get_system_config("current_semester");

$semester_data=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ($current_semester));
$semester_data=$semester_data[0];
$start_check_date=$semester_data['semester_start'];
$end_check_date=$semester_data['datechk_end'];
/*print $start_check_date;
print "|";
print $end_check_date;*/
$holidayData=sSelectTb($systemDb,'holiday','*','holiday_date between '.sQ($start_check_date).' AND '.sQ($end_check_date));
$holiday=array();
foreach($holidayData as $h){
    $holiday[$h['holiday_date']]=$h['holiday_name'];
}
//print_r($holiday);

$dates=date2date($start_check_date,$end_check_date,$dow=array(
    0=>false,
    1=>true,
    2=>true,
    3=>true,
    4=>true,
    5=>true,
    6=>false
    ));
//print_r($dates);
    foreach($dates as $d=>$v){
        //print $d."<br>";
        if($holiday[$d]){
            //print "<br>REMOVE ".$d;
            unset($dates[$d]);
        }
    }
//print_r($dates);


$group_id=$hGET['group'];
$activity_pass=get_system_config("pass_score_activity");
$assembly_pass=get_system_config("pass_score_assembly");
$morning_ceremony_pass=get_system_config("pass_score_morning_ceremony");

//$current_semester=$_SESSION['current_semester'];
$current_semester=get_system_config("current_semester");
$current_edu_year=mb_substr($current_semester,2,4);
$current_semester=mb_substr($current_semester,0,1);

$acts=sSelectTb($systemDb,"activity",'*','semester='.sQ($current_semester).' AND year='.sQ($current_edu_year).' AND group_id like "%'.$group_id.'%"');
$head=array(
    //'ที่',
    'รหัสนักเรียน',
    'ชื่อ',
    'สกุล',
    //'รหัสกลุ่ม',
    //'ระดับชั้น',
    //'ชื่อกลุ่ม',
);
$act_id=array();
foreach($acts as $row){
    array_push($head,'<a href="#" title="'.$row['name'].'">'.mb_substr($row['name'],0,10)).'</a>';
    array_push($act_id,$row['id']);
}
array_push($head,'กิจกรรมกลาง');
if(get_system_config("active_morning_ceremony")=='active')array_push($head,'กิจกรรมหน้าเสาธง');
if(get_system_config("active_assembly")=='active')array_push($head,'คาบกิจกรรม');
array_push($head,'ผลกิจกรรม');

$ac_data=sSelectTb($systemDb,"std",'*','group_id='.$group_id);
//print_r($complaint_data);
$table_data=array();
$i=0;

foreach($ac_data as $row){
    $i++;
    $table_data[$i]=array(
        //'no'=>$i,
        'student_id'=>$row['student_id'],
        'stu_fname'=>$row['stu_fname'],
        'stu_lname'=>$row['stu_lname'],
        //'group_id'=>$row['group_id'],
        //'level_name'=>$row['level_name'],
        //'major_name'=>$row['major_name'],
        //'<a href="'.site_url('main/admin/managestudent/view/group/'.$row['group_id']).'"><i class="material-icons col-red">search</i></a>'
    );
    
    $signAct=0;

    foreach($act_id as $act_row){
        $check_data=sSelectTb($systemDb,"entry_record",'*','act_id='.$act_row.' AND student_id='.sQ($row['student_id']));
        if(count($check_data)==0){
            $newData=array(
                'act_id'=>$act_row,
                'student_id'=>sQ($row['student_id']),
                'time_record'=>'NOW()',
                'time_update'=>'NOW()',
                'checker_id'=>current_user('id'),
                'entry_type'=>sQ('unCheck')
            );
            sInsertTb($systemDb,"entry_record",$newData);
            $check_data['entry_type']='unCheck';
        }else{
            $check_data=$check_data[0];
        }
        if($check_data['entry_type']=='check'){
            $table_data[$i][$act_row]='✔';
            $signAct++;
        }else if($check_data['entry_type']=='unCheck'){
            $table_data[$i][$act_row]='✗';
        }else{
            $table_data[$i][$act_row]='';
        }
    }
    if(count($act_id )>0){
        $percentage=$signAct/count($act_id)*100;
    }else{
        $percentage=100;
    }

    $table_data[$i]['sumact']=$signAct.' ครั้ง ('.number_format($percentage,2).'%)';
    if(get_system_config("active_morning_ceremony")=='active')$table_data[$i]['sumMorningCeremony']=$signAct.' ครั้ง ('.number_format($percentage,2).'%)';
    if(get_system_config("active_assembly")=='active')$table_data[$i]['sumAssembly']=$signAct.' ครั้ง ('.number_format($percentage,2).'%)';
    $table_data[$i]['grade']=$percentage>=$activity_pass?'ผ่าน':'<font color="red">ไม่ผ่าน</font>';

}


           

$data=array("head"=>$head,
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 0, "asc" ]]'
    );
    print datatable($data);
    ?>
    </div>