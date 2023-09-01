<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>วันหยุด ภาคเรียน <?php print get_system_config('current_semester'); ?></h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="dtable">
                             โปรดรอสักครู่..
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<?php
$data_modal=array(
    'id'=>'editHoliday',
    'title'=>'จัดการวันหยุด',
);

print gen_modal($data_modal);

$systemFoot.="<script>
            $(function(){
                load_holiday();
            });
                function load_holiday(){
                    $('#dtable').load('".site_url('ajax/admin/holiday/holiday_table')."');
                }

                function un_use(date){
                    $('#chk_'+date).html('<i class=\\'material-icons col-orange\\'>cached</i>');
                    $.ajax({url:'".site_url('ajax/admin/holiday/set_use/date/')."'+date+'/in_use/N', success: function( result ) {
                        if($.trim(result)=='ok'){
                            $('#chk_'+date).html('<a href=\\'#\\' onclick=\\'in_use(\"'+date+'\")\\'><i class=\\'material-icons\\'>check_box_outline_blank</i></a> ');
                        }else{
                            $('#chk_'+date).html('<a href=\\'#\\' onclick=\\'un_use(\"'+date+'\")\\'><i class=\\'material-icons col-orange\\'>error</i></a> ลองใหม่');
                        }
                    }
                    });
                    
                }

                function in_use(date){
                    $('#chk_'+date).html('<i class=\\'material-icons col-orange\\'>cached</i>');
                    $.ajax({url:'".site_url('ajax/admin/holiday/set_use/date/')."'+date+'/in_use/Y', success: function( result ) {
                        if($.trim(result)=='ok'){
                            $('#chk_'+date).html('<a href=\\'#\\' onclick=\\'un_use(\"'+date+'\")\\'><i class=\\'material-icons col-green\\'>check_box</i></a> ');
                        }else{
                            $('#chk_'+date).html('<a href=\\'#\\' onclick=\\'in_use(\"'+date+'\")\\'><i class=\\'material-icons col-orange\\'>error</i></a> ลองใหม่');
                        }
                    }
                    });
                    
                }
                </script>";