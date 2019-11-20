<?php
        	function genInput($data,$labelW=4,$inputW=8,$responsive=''){
        		$ret='';
        		global $systemFoot;
        		global $systemTop;
        		$tab_pane=0; //$tab_pane_nav='';
				$i=0;
				$tab_pane_nav='';
        		foreach($data as $k=>$row){
        			$i++;
						if($row['type']=='tab-pane') {
							if($tab_pane>0)$ret.='</div>';
							$tab_pane++;
							$tab_pane_nav.='<li class="'.$row['class'].'"><a href="#'.$row['id'].'" data-toggle="tab">'.$row['label'].'</a></li>
							';
							$ret.='<div class="'.$row['class'].' tab-pane" id="'.$row['id'].'">';
							continue;
						}else if($row['type']=='close-tab-pane') {
							if($tab_pane>0)$ret.='</div>';
							continue;
						}
						$attr='';
        			if(is_arraY($row['attr'])&&count($row['attr'])){
        			
        			foreach($row['attr'] as $a=>$c){
        				if(is_numeric($a)){
        				   $attr.=" ".$c;
        				}else{
        				   $attr.=$a."='".$c."'";
        				}
        			}
        		}
        			
        			if(!isset($row['class'])){
        				if($row['type']=='text'||$row['type']=='number'||$row['type']=='password'||$row['type']=='select'||$row['type']=='select'||$row['type']=='time'||$row['type']=='month')$row['class']='form-control';
        				else if($row['type']=='submit')$row['class']='btn btn-primary btn-block';
        				else if($row['type']=='checked'){
        					$row['class']='btn btn-primary btn-block';
        				}
        			}
        			if($row['type']!="hidden"){
        			$ret.="<h2 class=\"card-inside-title\">".$row['label']."</h2>";
        		$ret.="<div class=\"col-sm-12\"><div class=\"form-group\"><div class=\"form-line\">";
        		//$ret.="<label for=\"".$k."\" class=\"col-md-".($row['btLW']?$row['btLW']:$labelW)." control-label\">".$row['label']."</label>";
        		//$ret.="<div class=\"col-xs-".($row['btIW']?$row['btIW']:$inputW)." col-sm-".($row['btIW']?$row['btIW']:$inputW)." col-md-".($row['btIW']?$row['btIW']:$inputW)."  input-group\">";
        			}
        		static $wysiInit=false;
        		static $sourceHL=false;
        			if($row['type']=='html') {
        			   $ret.=$row['content'];
					}elseif($row['type']=='button') {
					   if(is_array($row['attr']))foreach($row['attr'] as $att=>$atval){
					      $attrs.=$att.'="'.$atval.'" ';
					   }
        			      $onClick=$row['onClick']?'onClick="'.$row['onClick'].'"':'';
							$ret.='<a href="'.($row['url']?$row['url']:'#').'" target="'.$row['attr'].'" class="'.$row['class'].'"'.$onClick.'>'.$row['value'].'</a>';
							//continue;
					}elseif($row['type']=='hidden'){
        				$ret.="<input type='hidden' id='".$k."' name='".$k."' value='".$row['value']."'>";
        			}elseif($row['type']=='date'){
        			$row['class']='form-control';
        				$ret.="<input type='date' min='".$row['min']."' max='".$row['max']."' id='".$k."' name='".$k."' ".$attr." value='".$row['value']."' class='".$row['class']."'>";
        			}elseif($row['type']=='textarea'){
        				$ret.="<textarea id='".$k."' name='".$k."' ".$attr." class='form-control' rows='4'>".$row['value']."</textarea>";
        			}elseif($row['type']=='wysiwyg'){
        				if(!$wysiInit){
        					$systemFoot.='<script src="'.site_url('system/library/ext/ckeditor/ckeditor.js',true).'"></script>';
        					$systemFoot.='<script src="'.site_url('system/library/ext/ckeditor/config.js',true).'"></script>';
        					//$systemFoot.="<script src='".site_url('system/template/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',true)."'></script>";
      						$wysiInit=true;
        			}
        				$ret.="<textarea id='".$k."' name='".$k."' ".$attr.">".$row['value']."</textarea>";
        				$systemFoot.="
        				<script>
        				$(function () {
        					CKEDITOR.replace('".$k."',{
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [
        
        {
          \"name\": \"tools\",
          \"groups\": [\"tools\"]
        },
        {
          \"name\": \"links\",
          \"groups\": [\"links\"]
        },
        {
          \"name\": \"paragraph\",
          \"groups\": [\"list\", \"blocks\"]
        },
        {
          \"name\": \"document\",
          \"groups\": [\"mode\"]
        },
        {
          \"name\": \"insert\",
          \"groups\": [\"insert\"]
        },
        {
          \"name\": \"styles\",
          \"groups\": [\"styles\"]
        }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      //removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
    });
        				});
        				</script>
        				";
        			}elseif($row['type']=='sourceHL'){
        				if(!$sourceHL){
        					$sourceHL=true;
        					$systemFoot.='<script src="'.
        					site_url("system/library/ext/codemirror/lib/codemirror.js",true).'"></script>
<link rel="stylesheet" href="'.
site_url("system/library/ext/codemirror/lib/codemirror.css",true).'">
<link rel="stylesheet" href="'.
site_url("system/library/ext/codemirror/theme/midnight.css",true).'">
<script src="'.
site_url("system/library/ext/codemirror/mode/javascript/javascript.js",true).'"></script>';
        				}
        				$ret.="<textarea id='".$k."' name='".$k."' ".$attr." class='".$row['class']."'>".$row['value']."</textarea>";
        			
        				$systemFoot.="
        				<script>
  var editor".$k." = CodeMirror.fromTextArea(".$k.", {
    lineNumbers: true
  });
editor".$k.".setOption(\"theme\", \"midnight\");
</script>";
        			
        			}elseif($row['type']=='file'){
        				
        				$row['class']=$row['class']==''?'btn btn-default':$row['class'];
        				
        				$ret.="<input type='file' name='".$k."' id='".$k."' ".$attr." class=\"hidden\" ".($row['multiple']?'multiple':'').">";
        				$ret.='<input type="text" id="'.$k.'_path" '.$attr.' class="form-control '.$row['textClass'].'" disabled>
        				<span class="input-group-btn">';
        				$ret.='<button class="form-control '.$row['class'].'" type="button" id="'.$k.'_btn">
						<i class="material-icons">picture_as_pdf</i> เลือกไฟล์</button>
            </span>';
        				$systemFoot.='
        					<script>
        						$(\'#'.$k.'_btn\').click(function(e){
    								e.preventDefault();
    								$(\'#'.$k.'\').click();
								});
								$(\'#'.$k.'\').change(function(){
    								$(\'#'.$k.'_path\').val($(this).val());
								});
        					</script>
        				';
        				
        			}elseif($row['type']=='select'){
        				
        				if($row['chosen']){
        					if(!isset($chosen)){
        					$chosen='init';
        					$systemTop.='<link rel="stylesheet" href="'.site_url('system/library/ext/chosen/chosen.min.css',true).'" />';
        					$systemFoot.='<script src="'.site_url('system/library/ext/chosen/chosen.jquery.js',true).'"></script>
        					<script>
					$(\'.chosen-select\').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off(\'resize.chosen\')
					.on(\'resize.chosen\', function() {
						$(\'.chosen-select\').each(function() {
							 var $this = $(this);
							 $this.next().css({\'width\': $this.parent().width()});
						})
					}).trigger(\'resize.chosen\');
					//resize chosen on sidebar collapse/expand
					$(document).on(\'settings.ace.chosen\', function(e, event_name, event_val) {
						if(event_name != \'sidebar_collapsed\') return;
						$(\'.chosen-select\').each(function() {
							 var $this = $(this);
							 $this.next().css({\'width\': $this.parent().width()});
						})
					});
			
			
					$(\'#chosen-multiple-style .btn\').on(\'click\', function(e){
						var target = $(this).find(\'input[type=radio]\');
						var which = parseInt(target.val());
						if(which == 2) $(\'#form-field-select-4\').addClass(\'tag-input-style\');
						 else $(\'#form-field-select-4\').removeClass(\'tag-input-style\');
					});
				

        					</script>
        					';
        					}
        				}
        				$multiple="";
        				$row['multiple']?$multiple=" multiple":$multiple="";
        				$ret.="<select $multiple id='".$k."' name='".$k."' ".$attr." class='".$row['class']."'>".gen_option($row['item'],$row['def'])."</select>";
        				
        			}else{
        				if($row['autocomplete']){
        					if(!isset($awesomplete)){
        					$awesomplete='init';
        					$systemFoot.='<link rel="stylesheet" href="'.site_url('system/library/ext/awesomplete/awesomplete.css',true).'" />
        					<script src="'.site_url('system/library/ext/awesomplete/awesomplete.js',true).'"></script>';
        					}
        					
        					foreach($row['item'] as $rowI){
        						$listString.="'".$rowI."',";
        					}
        					$systemFoot.='<script>
        					var input_'.$k.' = document.getElementById("'.$k.'");
        					new Awesomplete(input_'.$k.', {
								list: 	[
											'.$listString.'
										]
								});
        					</script>';
        				}
        		$ret.="<input type='".$row['type']."' name='".$k."' id='".$k."' placeholder='".$row['placeholder']."' value='".$row['value']."' ".$attr." ".$row['checked']." class='".$row['class']."'".($row['disable']?" disabled":"").">";
        			}
        		/*if(isset($row['icon']))$ret.='
        		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#calendar">
                <i class="'.$row['icon'].'"></i>
              </button>';*/
                    if($row['type']!="hidden"){
				$ret.="</div></div></div>
				";
                    }
        		/*
        			if (strpos($row['class'], 'flat-red') !== false) {
        				icheck();	
        			}*/
        		}
        		if($tab_pane>0) {
					$ret.='</div>';
					$ret='<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">'.$tab_pane_nav.' </ul><div class="tab-content'.$responsive.'">'.$ret.' </div></div>';
					}
        		return $ret."\r\n";
        	}
        	
        	function genForm($data){
        		global $systemFoot;
        		$attr='';
        		if(is_array($row['attr'])&&count($data['attr'])){
        			
        			if(is_array($data['attr'])){
        				foreach($data['attr'] as $k=>$v){
        				$attr.=$k."='".$v."'";
        				}
        			}else {
        				$attr.=" ".$data['attr'];
        			}
        		}
        		
        		if(!isset($data['method']))$data['method']='post';
        		$ret='';
        		if(isset($data['caption']))$ret.="<div class=\"box-header\"><h3>".$data['caption']."</h3></div>";
        		if($data['enctype']){
        		   $enc=' enctype="multipart/form-data"';
        		}else{
        		   $enc='';
        		}
        		$ret.="<form id='".$data['id']."' action='".$data['action']."' ".$attr." class=\"form-horizontal\" ".$enc."  role=\"form\" method='".$data['method']."'>";
        		//$ret.="<div class=\"box-body\">";
        		
        			$ret.=$data['item'];
        			
        			//$ret.="</div>";
        		$ret.="</form>";
        		if(is_array($data['ajaxSubmit'])){
        			$data['response']!=""?$responseId=$data['response']:$responseId='systemAlert';
        			$systemFoot.='<script>
        			var submited=false;
        			$( "#'.$data['id'].'" ).submit(function( event ) {
        			
         
        			submited=true;
        			$(\'#'.$responseId.'\').html(\'<div class=\"alert alert-info alert-dismissible\">โปรดรอสักครู่.. <i class=\"fa fa-refresh fa-spin\"/></div>\');
                                
  event.preventDefault();
  var $form = $( this ),
  ';
  $input_files='';
$bindingInput='';
$inputNo=0;
  	foreach($data['ajaxSubmit'] as $inputName=>$detail){
  		if($inputNo){
  			$bindingInput.=',';
  		}
  		$inputNo++;
  		//$('textarea#mytextarea').val();
  		if($detail['type']=='checkbox'){
  			$systemFoot.='input_'.$inputName.' = $("#'.$inputName.'").is(\':checked\') ? "'.$detail['value'].'" : false,';
  		}else if($detail['type']=='textarea'){
  			$systemFoot.='input_'.$inputName.' = $("#'.$inputName.'").val(),';
  		}else if($detail['type']=='file'){
  			$systemFoot.='input_'.$inputName.' = new FileReader(),';
  		}else if($detail['type']=='select'){
  		   if(is_array($detail['attr'])){if(in_array('multiple',$detail['attr'])){
  		      $systemFoot.='input_'.$inputName.'=[],';
  		         $fsc.='$("#'.$inputName.' option").each(function(i){
  		         if (this.selected == true) {
                        input_'.$inputName.'.push(this.value);
                }
  		      });';
  		      }
  		   }else{
  			$systemFoot.='input_'.$inputName.' = $("#'.$inputName.' option:selected").val(),';
  		   }
  		}elseif($detail['type']=='wysiwyg'){
  			$systemFoot.='input_'.$inputName.' = CKEDITOR.instances[\''.$inputName.'\'].getData(),';
  		}elseif($detail['type']=='sourceHL'){
  			$systemFoot.='input_'.$inputName.' = $("textarea#'.$inputName.'").val(),';
  		}else{
  		
  		$systemFoot.='input_'.$inputName.' = $form.find("input[name=\''.$inputName.'\']").val(),';
  		}
  		$bindingInput.=$inputName.':input_'.$inputName;
  		
  	}
  $systemFoot.='
    url = $form.attr( "action" );
    '.$fsc.'
  var posting = $.post( url, {'.$bindingInput.'} );
  posting.done(function( data ) {
    //$( "#result" ).empty().append( data );
    showUpdate(data);
    '.$data['onSubmit'].'
    window.scrollTo(0,0);
  });
});
function showUpdate(txt){
        $("#'.$responseId.'").html(txt);
      }
</script>
';
        		}
        		return $ret;
        	}
        	
        	
        	function gen_form($data){
        		global $systemFoot;
        		$attr='';
        		if(is_array($data['attr'])&&count($data['attr'])){
        			
        			if(is_array($data['attr'])){
        				foreach($data['attr'] as $k=>$v){
        				$attr.=$k."='".$v."'";
        				}
        			}else {
        				$attr.=" ".$data['attr'];
        			}
        		}
        		
        		if(!isset($data['method']))$data['method']='post';
        		$ret='';
        		if(isset($data['caption']))$ret.="<div class=\"box-header\"><h3>".$data['caption']."</h3></div>";
        		if($data['enctype']){
        		   $enc=' enctype="multipart/form-data"';
        		}else{
        		   $enc='';
        		}
        		$ret.="<form id='".$data['id']."' action='".$data['action']."' ".$attr." class=\"form-horizontal\" ".$enc."  role=\"form\" method='".$data['method']."'>";
        		//$ret.="<div class=\"box-body\">";
        		
        			$ret.=$data['item'];
        			
        			//$ret.="</div>";
        		$ret.="</form>";
        		if(is_array($data['ajaxSubmit'])){
        			$data['response']!=""?$responseId=$data['response']:$responseId='systemAlert';
        			$systemFoot.='<script>
        			var submited=false;
        			$( "#'.$data['id'].'" ).submit(function( event ) {
        			
         
        			submited=true;
        			$(\'#'.$responseId.'\').html(\'<div class=\"alert alert-info alert-dismissible\">โปรดรอสักครู่.. <i class=\"fa fa-refresh fa-spin\"/></div>\');
                                
  event.preventDefault();
  $.ajax({
url: "'.site_url($data['action']) .'", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
showUpdate(data);
}
});

});
function showUpdate(txt){
        $("#'.$responseId.'").html(txt);
      }
</script>
';
        		}
        		return $ret;
        	}
        	/*
        	function icheck(){
        		global $systemFoot;
        		static $called=0;
        		if(!$called){
        			$calles=1;
        		
        		$icheck_url=site_url('system/template/AdminLTE/plugins/iCheck/icheck.min.js',true);
        		$icheckCssURL=site_url('system/template/AdminLTE/plugins/iCheck/all.css',true);
        		$systemFoot.="<script src='".$icheck_url."'></script>";
        		$systemFoot.="
        		<script>
    $('input[type=\"checkbox\"].flat-red, input[type=\"radio\"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

</script>
<link rel=\"stylesheet\" href=\"".$icheckCssURL."\">
        		";
        	}
        	}*/
        	?>