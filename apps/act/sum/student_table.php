<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$group_id=$hGET['group'];

$current_edu_year=$_SESSION['current_edu_year'];
$current_semester=$_SESSION['current_semester'];


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
array_push($head,'การเข้าร่วมกิจกรรม');
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
        $check_data=$check_data[0];
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

    $table_data[$i]['sum']=$signAct.' ครั้ง (ร้อยละ '.number_format($percentage,2).')';
    $table_data[$i]['grade']=$percentage>=60?'ผ่าน':'<font color="red">ไม่ผ่าน</font>';

}


           

$data=array("head"=>$head,
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 1, "desc" ]]'
    );
    print datatable($data);
    ?>
    </div>