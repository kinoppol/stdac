<?php
load_fun('form');

$current_edu_year=date('m')<4?date('Y')+542:date('Y')+543;
            $current_semester=date('m')<10&&date('m')>4?1:2;
            $current_semester=$current_semester.'/'.$current_edu_year;

        if(get_system_config("current_semester")!=''){
            $current_semester=get_system_config("current_semester");

            
        }

            for($i=date('Y')+543+1;$i>=date('Y')+543-3;$i--){
                $semester_data['2/'.$i]='2/'.$i;
                $semester_data['1/'.$i]='1/'.$i;
            }


$inputDetail = array(
    'tab1'=>array(
    "id"=>"generalTab",
    "label"=>"ทั่วไป",
    "type"=>"tab-pane",
    "class"=>"active"
    ),
    'school_name' => array(
        'label' => 'ชื่อสถานศึกษา',
        'type' => 'text',
        'value'=>get_system_config("school_name")
    ),
    'rms_url' => array(
        'label' => 'ที่อยู่ระบบ RMS (โปรดระบุ http://,https://)',
        'type' => 'text',
        'value'=>get_system_config("rms_url")
    ),
    'current_semester' => array(
        'label' => 'ภาคเรียนปัจจุบัน',
        'type' => 'select',
        'item'=>$semester_data,
        'def'=>$current_semester
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'บันทึก'
    ),
    
    'tab2'=>array(
        "id"=>"usageTab",
        "label"=>"การใช้งาน",
        "type"=>"tab-pane",
        "class"=>""
        ),
    'active'=>array(
        'id'=>'active_act',
        'type'=>'html',
        'content'=>'<a href="#" id="active_act"
        onClick="active_act()"><i class="material-icons col-green">check_box</i></a> กิจกรรมกลาง
        <span id="assembly"></span>
       <span id="morning_ceremony"></span>
      '),
    
      'tab3'=>array(
          "id"=>"signTab",
          "label"=>"การลงนาม",
          "type"=>"tab-pane",
          "class"=>""
          ),
      'signName'=>array(
          'label' => 'ชื่อ-สกุล ผู้ลงนามในเอกสาร',
          'id'=>'signName',
          'type' => 'text',
          'value'=>get_system_config("signName")
          ),
      'signPosition'=>array(
          'label' => 'ตำแหน่งของผู้ลงนามในเอกสาร',
          'id'=>'signPosition',
          'type' => 'text',
          'value'=>get_system_config("signPosition")
          ),
          'submit2' => array(
              'label' => '&nbsp;',
              'type' => 'submit',
              'value' => 'บันทึก'
          ),
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);
?>
<div id="ajaxResponse">
</div>
<div class="container-fluid">
            <div class="block-header">
                <h2>ตั้งค่าระบบ</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
<?php
$saveURL=site_url('ajax/admin/config/save');
print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));
?>
</div>
</div>
</div>
</div>
</div>

<?php
$systemFoot.='
<script>
$(function(){
    '.(get_system_config("active_assembly")=='active'?'active_assembly();':'disactive_assembly();').'
    '.(get_system_config("active_morning_ceremony")=='active'?'active_morning_ceremony();':'disactive_morning_ceremony();').'
});

function active_act(){
    alert("ไม่สามารถปิดการใช้งานระบบนี้ได้");
}

function active_assembly(){
    $.get("'.site_url('ajax/admin/config/save_active/set/active_assembly').'",function(data){
        if($.trim(data)=="ok"){
            $("#assembly").html("<a href=\\"#\\" onclick=\\"disactive_assembly()\\"><i class=\\"material-icons col-green\\">check_box</i></a> คาบกิจกรรม");
        }
    });
}
function disactive_assembly(){
    $.get("'.site_url('ajax/admin/config/save_active/set/disactive_assembly').'",function(data){
        if($.trim(data)=="ok"){
            $("#assembly").html("<a href=\\"#\\" onclick=\\"active_assembly()\\"><i class=\\"material-icons col-black\\">check_box_outline_blank</i></a> คาบกิจกรรม");
        }
    });
}

function active_morning_ceremony(){
    $.get("'.site_url('ajax/admin/config/save_active/set/active_morning_ceremony').'",function(data){
        if($.trim(data)=="ok"){
            $("#morning_ceremony").html("<a href=\\"#\\" onclick=\\"disactive_morning_ceremony()\\"><i class=\\"material-icons col-green\\">check_box</i></a> กิจกรรมหน้าเสาธง");
        }
    });
}
function disactive_morning_ceremony(){
    $.get("'.site_url('ajax/admin/config/save_active/set/disactive_morning_ceremony').'",function(data){
        if($.trim(data)=="ok"){
            $("#morning_ceremony").html("<a href=\\"#\\" onclick=\\"active_morning_ceremony()\\"><i class=\\"material-icons col-black\\">check_box_outline_blank</i></a> กิจกรรมหน้าเสาธง");
        }
    });
}
</script>';