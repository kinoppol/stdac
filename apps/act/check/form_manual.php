<div id="chk_all">
<a href="#"
         onClick="check_all_std()"><i class="material-icons col-black">check_box_outline_blank</i></a> เช็คชื่อให้ทุกคน
        </a>
</div>
<div id="student_Response">
โปรดรอสักครู่..
</div>
<?php

$id=$hGET['id'];
$mode='';
if($hGET['mode']=='morningCeremony'){
    $id=$hGET['gid'];
    $mode='/mode/morningCeremony';
}

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
