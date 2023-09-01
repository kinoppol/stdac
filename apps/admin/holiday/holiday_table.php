<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');

$hl_data=sSelectTb($systemDb,"holiday",'*','semester = '.sQ(get_system_config('current_semester')));
//print_r($complaint_data);
$table_data=array();
$i=0;
foreach($hl_data as $row){
    $i++;
    if($row['in_use']=='Y'){

        $chk_box='
        <div id="chk_'.$row['holiday_date'].'" class="chk_btn">
            <a href="#"
                onClick="un_use(\''.$row['holiday_date'].'\')"><i class="material-icons col-green">check_box</i></a>
            </a>
        </div>';
    }else{
    $chk_box='
    <div id="chk_'.$row['holiday_date'].'" class="chk_btn">
        <a href="#"
            onClick="in_use(\''.$row['holiday_date'].'\')"><i class="material-icons col-black">check_box_outline_blank</i></a>
        </a>
    </div>';
    }
    $table_data[]=array(
        //'no'=>$i,
        'date'=>$row['holiday_date'],
        'holiday_name'=>$row['holiday_name'],
        'manage'=>$chk_box,
    );
    
}
$data=array("head"=>array(
    //'ที่',
    'วันที่',
    'ชื่อวันหยุด',
    'ใช้ในการคำนวณ'
    ),
    'id'=>'group_table',
    'item'=>$table_data,
    'pagelength'=>10,
    'order'=>'[[ 0, "asc" ]]'
    );
    print datatable($data);
    ?>
    </div>