<div id="chk_all">
<a href="#"
         onClick="add_all_group()"><i class="material-icons col-black">check_box_outline_blank</i></a> เลือกทุกกลุ่ม
        </a>
</div>

<div id="group_table_respons">
โปรดรอสักครู่
</div>
<?php
    $systemFoot.='
    <script>
        $(function(){
            load_table_group();
        });

        function load_table_group(){
            $("#group_table_respons").load("'.site_url("ajax/act/group/group_table/id/".$hGET['id']).'");
        }

        function add_group(gid){
            $("#chk_"+gid).html("<i class=\\"material-icons col-orange\\">cached</i>");
            $.ajax({url:"'.site_url('ajax/act/group/select_group/id/'.$hGET['id'].'/gid/').'"+gid, success: function( result ) {
                if($.trim(result)=="ok"){
                    $("#chk_"+gid).html("<a href=\\"#\\" onclick=\\"del_group("+gid+")\\"><i class=\\"material-icons col-green\\">check_box</i></a> ");
                }else{
                    alert(result);
                }
            }
            });
            
        }

        function del_group(gid){
            $("#chk_"+gid).html("<i class=\\"material-icons col-orange\\">cached</i>");
            $.ajax({url:"'.site_url('ajax/act/group/deselect_group/id/'.$hGET['id'].'/gid/').'"+gid, success: function( result ) {
                if($.trim(result)=="ok"){
                    $("#chk_"+gid).html("<a href=\\"#\\" onclick=\\"add_group("+gid+")\\"><i class=\\"material-icons col-black\\">check_box_outline_blank</i></a> ");
                }else{
                    alert(result);
                }
            }
            });
            
        }
        function add_all_group(){
            $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
            $.ajax({url:"'.site_url('ajax/act/group/select_all/id/'.$hGET['id']).'", success: function( result ) {
                if($.trim(result)=="ok"){
                    $("#chk_all").html("<a href=\\"#\\" onclick=\\"del_all_group()\\"><i class=\\"material-icons col-green\\">check_box</i></a> เลือกทุกกลุ่ม");
                    load_table_group();
                }else{  
                    alert(result);
                }
            }
            });
        }
        function del_all_group(){
            $("#chk_all").html("<i class=\\"material-icons col-orange\\">cached</i>");
            $.ajax({url:"'.site_url('ajax/act/group/deselect_all/id/'.$hGET['id']).'", success: function( result ) {
                if($.trim(result)=="ok"){
                    $("#chk_all").html("<a href=\\"#\\" onclick=\\"add_all_group()\\"><i class=\\"material-icons col-black\\">check_box_outline_blank</i></a> เลือกทุกกลุ่ม");
                    load_table_group();
                }else{
                    alert(result);
                }
            }
            });
        }
    </script>
    ';