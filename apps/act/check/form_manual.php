<?php
    
$id=$hGET['id'];
    $mode='';
    $dow_arr=array('0'=>'อาทิตย์','1'=>'จันทร์','2'=>'อังคาร','3'=>'พุธ','4'=>'พฤหัสบดี','5'=>'ศุกร์','6'=>'เสาร์');



    if($hGET['id']=='morningCeremony'||$hGET['id']=='assembly'){
        $id=$hGET['id'];
        $mode='/gid/'.$hGET['gid'];

        $checker_data=sSelectTb($systemDb,'checker','*','group_id='.$hGET['gid'].' AND semester='.sQ(get_system_config('current_semester')));
        $checker_data=$checker_data[0];
        //print $checker_data['morning_ceremony_date'];

        $semester=sSelectTb($systemDb,'semester','*','semester_eduyear='.sQ(get_system_config('current_semester')));
        $semester=$semester[0];

        $period = new DatePeriod(
            new DateTime($semester['semester_start']),
            new DateInterval('P1D'),
            new DateTime($semester['semester_end'])
       );
       $dow=explode(',',$checker_data['morning_ceremony_date']);
       $dates=array();
       foreach ($period as $key => $value) {
           if(is_numeric(array_search(date('w', strtotime($value->format('Y-m-d'))),$dow))){
            $dates[$value->format('Y-m-d')]=$dow_arr[date('w', strtotime($value->format('Y-m-d')))].' ที่ '.dateThai($value->format('Y-m-d'));
           }
        }
        //print_r($dates);
        $date_select="วันที่เช็คชื่อ <select>
        ".gen_option($dates,date('Y-m-d'))."
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
<script>
    $(function(){
        load_student();
    });
    function load_student(){
        $("#student_Response").load("'.site_url("ajax/act/check/ajaxList/id/".$id.$mode).'");
    }
    function check_std(std_id){
        $("#chk_"+std_id).html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudent/id/'.$hGET['id'].'/std_id/').'"+std_id+"/type/check", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"unCheck_std("+std_id+")\\"><i class=\\"material-icons col-green\\">check_box</i></a> ");
            }else{            
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"check_std("+std_id+")\\"><i class=\\"material-icons col-orange\\">error</i></a> ");
            }
        }
        });
        
    }
    function unCheck_std(std_id){
        $("#chk_"+std_id).html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudent/id/'.$hGET['id'].'/std_id/').'"+std_id+"/type/unCheck", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"check_std("+std_id+")\\"><i class=\\"material-icons\\">check_box_outline_blank</i></a> ");
            }else{
                $("#chk_"+std_id).html("<a href=\\"#\\" onclick=\\"unCheck_std("+std_id+")\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    
    }
    
    function check_all_std(){
        $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudentAll/id/'.$hGET['id']).'/type/check", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"unCheck_all_std()\\"><i class=\\"material-icons col-green\\">check_box</i></a> เช็คชื่อให้ทุกคน");
                load_student();
            }else{
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"check_all_std()\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    }
    function unCheck_all_std(){
        $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
        $.ajax({url:"'.site_url('ajax/act/check/checkStudentAll/id/'.$hGET['id']).'/type/unCheck", success: function( result ) {
            if($.trim(result)=="ok"){
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"check_all_std()\\"><i class=\\"material-icons\\">check_box_outline_blank</i></a> เช็คชื่อให้ทุกคน");
                load_student();
            }else{
                $("#chk_all").html("<a href=\\"#\\" onclick=\\"unCheck_all_std()\\"><i class=\\"material-icons col-orange\\">error</i></a> ลองใหม่");
            }
        }
        });
    }
</script>
';
