<?php
$rms=get_system_config("rms_url");
$current_semester=get_system_config("current_semester");
$year_data=explode('/',$current_semester);
$holiday_data=rms_get_data($rms,'nutty','stopday');

$data=array();
$holidayTransfer=0;
sDeleteTb($systemDb,'holiday','semester='.sQ($current_semester));
foreach($holiday_data as $row){
    if($row['stopday_eduyear']!=$current_semester)continue;
    
    //print ">>>".$row['stopday_eduyear'];
    $data['holiday_date']=sQ($row['stopday_date']);
    $data['holiday_name']=sQ($row['stopday_name']);
    $data['semester']=sQ($current_semester);
    //print count($data);
    //print_r($data);
    $result=sInserttb($systemDb,'holiday',$data,true);
    if($result){
        $holidayTransfer++;
    }
}

function get_hora_holiday($year){
    $holidayTransfer=0;
$horaHoliday_data=file_get_contents('http://www.myhora.com/calendar/ical/holiday.aspx?'.$year.'.csv');

$array = array_map("str_getcsv", explode("\n", $horaHoliday_data));
//print_r($array);
$i=0;
$keys=array();
$holidays=array();
foreach($array as $row){
    if($i==0){
        $keys=$row;
    }else{
        $j=0;
        $holiday=array();
        foreach($row as $crow){
            $holiday[$keys[$j]]=$crow;
            $j++;
        }
        array_push($holidays,$holiday);
    }
    $i++;
}
//print_r($keys);
//$json = json_encode($array);
//print_r($holidays);

foreach($holidays as $row){
    $canceled=(mb_substr($row['Subject'],0,3)=='<s>'?1:0);// วัยหยุดที่ขึ้นต้นด้วย <s> (โดนขีดฆ่า) หมายถึงโดนยกเลิก
    if($canceled==1){
        continue;
    }
    global $systemDb;
//print_r($row);
    $holiday_date=explode("/",$row['Start Date']);
    //print_r($holiday_date);
    /*print $year;
    print "-";*/
    if(trim($holiday_date[2])=='')continue;
    $holiday_date=$holiday_date[2].'-'.$holiday_date[1].'-'.$holiday_date[0];
    $semester_data=sSelectTb($systemDb,'semester','semester_eduyear','semester_start<='.sQ($holiday_date).' AND semester_end >='.sQ($holiday_date));
    $semester=$semester_data[0]['semester_eduyear'];
    //print $holiday_date;
    $data=array(
        'holiday_date'=>sQ($holiday_date),
        'holiday_name'=>sQ($row['Subject']),
        'semester'=>sQ($semester)
    );
    $chk=sSelectTb($systemDb,'holiday','count(*) as c','holiday_date='.$data['holiday_date']);
    if($chk[0]['c']==0){
        //print "INSERT";
        $result=sInserttb($systemDb,'holiday',$data);
    }else{
        //print "UPDATE";
        $result=sUpdatetb($systemDb,'holiday',$data,'holiday_date='.$data['holiday_date']);
    }
    if($result){
        $holidayTransfer++;
    }else{
        $db->error;
    }
    
}
    return $holidayTransfer;
}

$holidayTransfer+=get_hora_holiday($year_data[1]);
$holidayTransfer+=get_hora_holiday($year_data[1]+1);

print "โอนข้อมูลวันหยุดภาคเรียนที่ ".$current_semester." จำนวน ".$holidayTransfer." วัน";
