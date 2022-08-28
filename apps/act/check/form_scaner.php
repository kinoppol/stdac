<script src="<?php print site_url('system/library/ext/barcodescan/html5-qrcode.min.js',true); ?>"></script>
<div id="ajaxResponse">
</div>
<div style="width: 100%;" id="reader"></div>
<button class="btn btn-danger" id="use_cam"><i class="material-icons">photo_camera</i> ใช้กล้อง</button>
<?php

load_fun('system_alert');
load_fun('form');
$acId=$hGET['id'];
$mode=$hGET['mode'];
    if(is_numeric($acId)){
        $ac_data=sSelectTb($systemDb,'activity','*','id='.$acId);
        $ac_data=$ac_data[0];

        if($ac_data['group_id']==''||$ac_data['group_id']=='[]'){
          
          $msg=" ยังไม่ได้เลือกกลุ่มผู้เรียนเพื่อเข้าร่วมกิจกรรม";
    
          $data['icon']='warning';
          $data['color']='alert-warning';
          $data['text']=$msg;
          print genAlert($data);
          exit();
    }
    }
    $saveURL=site_url('ajax/act/check/entry_save/id/'.$acId.'/gid/'.$hGET['gid']);
    


$inputDetail = array(
    'student_id' => array(
        'label' => 'รหัสประจำตัวนักศึกษา',
        'type' => 'text',
        'placeholder' => 'ระบุรหัสประจำตัวนักศึกษา',
        'icon' => 'settings_overscan',
        'value' => ''
    ),
    'submit' => array(
        'label' => '&nbsp;',
        'type' => 'submit',
        'value' => 'ตกลง'
    ),
);
$onSubmit .= '
//alert("Save");
';
$inputForm = genInput($inputDetail, 4, 12);

$systemFoot.='
<script> 
var intObj;
$(function() {
  intObj=setInterval(focus_std,3000);
    
});
function focus_std(){
    $( "#student_id" ).focus();
}
</script>
';

print genForm(array(
    'id' => 'bookForm',
    'action' => $saveURL,
    'ajaxSubmit' => $inputDetail,
    'response' => 'ajaxResponse',
    'onSubmit' => $onSubmit,
    'item' => $inputForm
));

$systemFoot.="
    <script>
    $(\"#student_id\").on(\"keypress\",function (event) {    
        //$(this).val($(this).val().replace(/[^\d].+/, \"\"));
         if ((event.keyCode < 48 || event.keyCode > 57)&&event.keyCode != 13) {
           event.preventDefault();
           if(event.keyCode == 3592){
             $(this).val($(this).val()+'0');
           }else if(event.keyCode == 3653){
             $(this).val($(this).val()+'1');
           }else if(event.keyCode == 47){
             $(this).val($(this).val()+'2');
           }else if(event.keyCode == 45||event.keyCode == 189){
             $(this).val($(this).val()+'3');
           }else if(event.keyCode == 3616){
             $(this).val($(this).val()+'4');
           }else if(event.keyCode == 3606){
             $(this).val($(this).val()+'5');
           }else if(event.keyCode == 3640){
             $(this).val($(this).val()+'6');
           }else if(event.keyCode == 3638){
             $(this).val($(this).val()+'7');
           }else if(event.keyCode == 3588){
             $(this).val($(this).val()+'8');
           }else if(event.keyCode == 3605){
             $(this).val($(this).val()+'9');
           }

         }
     });

     function onScanSuccess(decodedText, decodedResult) {
      // Handle on success condition with the decoded text or result.
      //alert('Scan result:'+decodedText);
      $(\"#student_id\").val(decodedText);
      $(\"#bookForm\").submit();
  }
  
  var html5QrcodeScanner = new Html5QrcodeScanner(
    \"reader\", { fps: 10, qrbox: { width: 250, height: 250 } });
  
  $(\"#use_cam\").click(function(){
    html5QrcodeScanner.render(onScanSuccess);
    $(\"#use_cam\").hide();
    clearInterval(intObj);
  });
  

    </script>
";