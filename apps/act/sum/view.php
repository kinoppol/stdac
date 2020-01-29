<div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>กลุ่มผู้เรียน</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php print site_url('main/act/transaction/view'); ?>">ดูทั้งหมด</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                        <form method="post">
                        <?php
                            print_r($_POST);
                        ?>
    ภาคเรียน <select name="semester">
        <?php
            $current_edu_year=date('m')<4?date('Y')+542:date('Y')+543;
            $current_semester=date('m')<10&&date('m')>4?1:2;
        if(isset($_POST['semester'])){
            $current_edu_year=mb_substr($_POST['semester'],2,4);
            $current_semester=mb_substr($_POST['semester'],0,1);

            
        }
        $_SESSION['current_edu_year']=$current_edu_year;
        $_SESSION['current_semester']=$current_semester;

            for($i=date('Y')+543+1;$i>=date('Y')+543-3;$i--){
                $selected1=($current_semester.'/'.$current_edu_year)==('1/'.$i)?' selected':'';
                $selected2=($current_semester.'/'.$current_edu_year)==('2/'.$i)?' selected':'';
                print "<option value='2/".$i."'".$selected2.">2/".$i."</option>";
                print "<option value='1/".$i."'".$selected1.">1/".$i."</option>";
            }
        ?> 
    </select>
    <input type="submit" value="ตกลง">
</form>
                            <div id="grouptable">
                            </div>
                        </div>
                    </div>
                </div>
    </div>

<?php


$systemFoot.="<script>
            $(function(){
                load_group();
            });
                function load_group(){
                    $('#grouptable').load('".site_url('ajax/act/sum/group_table')."');
                }
                </script>";