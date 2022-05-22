<?php
    
load_fun('activity');
$id=$hGET['id'];
    $mode='';
    $dow_arr=array('0'=>'อาทิตย์','1'=>'จันทร์','2'=>'อังคาร','3'=>'พุธ','4'=>'พฤหัสบดี','5'=>'ศุกร์','6'=>'เสาร์');

    $holiday=sSelectTb($systemDb,'holiday','*','semester = '.sQ(get_system_config('current_semester')));
    $holidays=array();
    $ignoreDate=array();
    foreach($holiday as $row){
        if($row['in_use']=='N'){
            $ignoreDate[]=$row['holiday_date'];
        }else{
            $holidays[]=$row['holiday_date'];
        }
    }


    if($hGET['id']=='morningCeremony'||$hGET['id']=='assembly'){
        $id=$hGET['id'];
        $mode='/gid/'.$hGET['gid'];

        $checker_data=sSelectTb($systemDb,'checker','*','group_id='.$hGET['gid'].' AND semester='.sQ(get_system_config('current_semester')));
        $checker_data=$checker_data[0];
        //print $checker_data['morning_ceremony_date'];

        $semester=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ(get_system_config('current_semester')));
        $semester=$semester[0];

        
        $after_check_days=get_system_config('activity_after_check');
       if($hGET['id']=='morningCeremony'){
        $dow=explode(',',$checker_data['morning_ceremony_date']);
        $after_check_days=get_system_config('morning_ceremony_after_check');
       }else if($hGET['id']=='assembly'){
        $dow=explode(',',$checker_data['assembly_date']);
        $after_check_days=get_system_config('assembly_after_check');
       }

        $dates=date2date($semester['semester_start'],$semester['semester_end'],$dow,$ignoreDate);
       $lasted_date='';
       $i=0;
       $oldest_day=date("Y-m-d",strtotime('- '.$after_check_days.' Days'));
       foreach ($dates as $date=>$t) {
            $i++;
            
            $disable_msg=in_array($date,$holidays)?'(วันหยุด) ':'';
            if(strtotime($date)<(strtotime('- '.$after_check_days.' Days'))){
                if($disable_msg==''){
                    if($after_check_days>1){
                        $disable_msg='(เลยกำหนด '.$after_check_days.' วัน) ';
                    }else{
                        $disable_msg='(ไม่อนุญาตให้เช็คชื่อย้อนหลัง) ';                        
                    }
                }
                array_push($holidays,$date);
            }if(strtotime($date)<time()&&!in_array($date,$holidays)){
                $lasted_date=$date;
            }else{
                array_push($holidays,$date);
            }

            $dates[$date]='ครั้งที่ '.$i.' '.$disable_msg.$dow_arr[date('w', strtotime($date))].' ที่ '.dateThai($date);
            
        }
        //print_r($dates);
        $date_select="วันที่เช็คชื่อ <select id=\"date_selector\">
        ".gen_option($dates,$lasted_date,$holidays)."
        <select>";
    }

    print  $date_select;
?>
<div id="chk_all">
<a href="#"
         onClick="check_all_std()"><i class="material-icons col-black">check_box_outline_blank</i></a> เช็คชื่อให้ทุกคน
        </a>
</div>
<div id="student_Response">
โปรดรอสักครู่..
</div>
<?php


$systemFoot.='
<style>
    select option[disabled] { color: #F00; }
</style>
<script>
$("#date_selector").change(function(){
    $("#student_Response").text("โปรดรอสักครู่..");
    $("#chk_all").html("<a href=\\"#\\" onclick=\\"check_all_std()\\"><i class=\\"material-icons\\">check_box_outline_blank</i></a> เช็คชื่อให้ทุกคน");
    load_student($(this).val());
});
    $(function(){
        load_student("'.$lasted_date.'");
    });
    function load_student(date_check){
        $("#student_Response").load("'.site_url("ajax/act/check/ajaxList/id/".$id.$mode."/date/").'"+date_check);
    }
    function check_std(std_id,date=false){
        $("#chk_"+std_id).html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudent/id/'.$hGET['id'].'/std_id/').'"+std_id+"/type/check/date/"+date, success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"optionCheck_std("+std_id+",\'"+date+"\')\\"><i class=\\"material-icons col-green\\">check_box</i></a> ");
            }else{            
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"check_std("+std_id+",\'"+date+"\')\\"><i class=\\"material-icons col-orange\\">error</i></a> ");
            }
        }
        });
        
    }

    function late_std(std_id,date=false){
        $("#chk_"+std_id).html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudent/id/'.$hGET['id'].'/std_id/').'"+std_id+"/type/late/date/"+date, success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"optionCheck_std("+std_id+",\'"+date+"\')\\" title=\\"สาย\\"><i class=\\"material-icons col-orange\\">access_time</i></a> ");
            }else{            
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"check_std("+std_id+",\'"+date+"\')\\"><i class=\\"material-icons col-orange\\">error</i></a> ");
            }
        }
        });
        
    }

    function unCheck_std(std_id,date=false){
        $("#chk_"+std_id).html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudent/id/'.$hGET['id'].'/std_id/').'"+std_id+"/type/unCheck/date/"+date, success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"check_std("+std_id+",\'"+date+"\')\\"><i class=\\"material-icons\\">check_box_outline_blank</i></a> ");
            }else{
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"unCheck_std("+std_id+",\'"+date+"\')\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    
    }
    
    function check_all_std(){
        var date=$("#date_selector").val();
        $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudentAll/id/'.$hGET['id']).'/type/check/date/"+date+"'.$mode.'", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"unCheck_all_std()\\"><i class=\\"material-icons col-green\\">check_box</i></a> เช็คชื่อให้ทุกคน");
                load_student(date);
            }else{
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"check_all_std()\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    }
    function unCheck_all_std(){
        if(!confirm("ยกเลิกการเช็คชื่อทั้งหมด")){
            return false;
        }
        var date=$("#date_selector").val();
        $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudentAll/id/'.$hGET['id']).'/type/unCheck/date/"+date+"'.$mode.'", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"check_all_std()\\"><i class=\\"material-icons\\">check_box_outline_blank</i></a> เช็คชื่อให้ทุกคน");
                load_student(date);
            }else{
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"unCheck_all_std()\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    }
    function optionCheck_std(std_id,date=false){
        //alert(date);
        $("#optionCheck").modal("show");
    var md=$("#optionCheck");
        md.find(".modal-body").html("<button class=\'btn btn-success\' style=\'width:20%;text-align:left\' onclick=\'select_check(\"check\",\""+std_id+"\",\""+date+"\")\'><i class=\'material-icons\'>check_box</i> มา</button> <button class=\'btn btn-danger\'  style=\'width:20%;text-align:left\' onclick=\'select_check(\"unCheck\",\""+std_id+"\",\""+date+"\")\'><i class=\'material-icons\'>check_box_outline_blank</i> ขาด</button> <button class=\'btn btn-warning\'  style=\'width:20%;text-align:left\' onclick=\'select_check(\"late\",\""+std_id+"\",\""+date+"\")\'><i class=\'material-icons\'>access_time</i> สาย</button>");
    }

    function select_check(select_type,std_id,date){
        $("#optionCheck").modal("hide");
        if(select_type=="check"){
            check_std(std_id,date);
        }else if(select_type=="unCheck"){
            unCheck_std(std_id,date);
        }else if(select_type=="late"){
            late_std(std_id,date);
        }
    }
</script>
';
