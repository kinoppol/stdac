<?php

function htmlTable($data=NULL){
   
    $tableWidth=$data['width']?' width="'.$data['width'].'"':'';
   $ret.=' <table '.$data['tableTag'].' class="'.$data['class'].'" id="'.$data['id'].'"'.$tableWidth.'>
    <thead>
                <tr>';
    foreach ($data['head'] as $row){
    		if(is_array($row)){
    		   if($row['class'])$classDetail='class="'.$row['class'].'"';
    		   else $classDetail='';
    		   if($row['style'])$styleDetail='style="'.$row['style'].'"';
    		   else $styleDetail='';
    			$ret.='<th '.$row['attr'].' width="'.$row['width'].'"'.$classDetail.$styleDetail.'>'.$row['content'].'</th>';
    		}else{
                  $ret.='<th>'.$row.'</th>';
    		}
    }
                $ret.='</tr></thead><tbody>';
    if($data['item']){
    	$i=0;
    foreach($data['item'] as $row){
        if(is_array($linkArr))$ret.='<tr class="clickable-row" onclick="readDoc('.$linkArr['uri'][$i].')" data-href="'.$linkArr['uri'][$i].'">';
        else $ret.='<tr>';
        foreach($row as $v){
           if(is_array($v)){
    		   if($v['class'])$classDetail=' class="'.$v['class'].'"';
    		   if($v['col']>1)$col=' colspan="'.$v['col'].'"';
    		   else{
    		      $col='';
    		   }
    			$ret.='<td width="'.$v['width'].'"'.$classDetail.$col.'>'.$v['content'].'</td>';
    		}else{
                  $ret.='<td style="vertical-align:middle; text-align:center;" data-href="'.($linkArr['uri'][$i]?$linkArr['uri'][$i]:"Hello").$linkArr['attr'].'">'.$v.'</td>';
    		}
        }
        $ret.='</tr>';
                  $i++;
    }
    
     if(is_array($linkArr)){
     	$systemFoot.='
     	<style>
     		*[data-href] {
  			cursor: pointer;
			}
			*[data-href] :hover{
  			text-decoration: underline; 
			}
     	</style>
     	<script>
     		function readDoc(id){
     			window.location = "'.$linkArr['url'].'"+id;
     		}
     	</script>
     	';
     }
    
    }
            $ret.='</tbody></table>';
    return $ret;
}

function rhTable($data=NULL,$linkArr=NULL){
    global $systemFoot;
    if($data['search'])$search='<div class="box-tools responsive">        
                <form action="'.site_url('main/statistic/business/report').'" method="post">
                <div class="input-group input-group-sm" style="width: 150px;">
                <input type="hidden" name="search" value="yes">
                  <input type="text" class="form-control pull-right" name="q" placeholder="ค้นหา" value="'.$_SESSION['option']['q'].'">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>                 
                </div>
                </form></div>';
    if($data['filter'])$filter='<div class="input-group input-group-sm">
        <div class="col-xs-5 form-group" style="width: 150px;">
        <label>ประเทศ</label>
                <select class="form-control">
                    <option>ทุกประเทศ</option>
                    <option>ประเทศไทย</option>
                    <option>ต่างประเทศ</option>
                  </select>
                  </div>
        <div class="col-xs-5 form-group" style="width: 150px;">
        <label>ภาค</label>
                <select class="form-control">
                    <option>ทุกภาค</option>
                    <option>กลาง</option>
                    <option>เหนือ</option>
                    <option>ตะวันออก</option>
                    <option>ตะวันออกเฉียงเหนือ</option>
                    <option>ใต้</option>
                  </select>
                  </div>
        <div class="col-xs-5 form-group" style="width: 150px;">
                  <label>จังหวัด</label>
                <select class="form-control">
                    '.$province_option.'
                  </select>
                  </div>
              </div>
           ';
    
    $ret.='<div class="box-header">
              <h3 class="box-title">'.$data['name'].'</h3>
                  

              '.$search.'
                  </div>
              '.$filter.'
            ';
    $tableWidth=$data['width']?' width="'.$data['width'].'"':'';
    $ret.=' <table '.$data['tableTag'].' class="table table-hover table-striped table-bordered nowrap '.$data['class'].'" id="'.$data['id'].'"'.$tableWidth.'>
    <thead class="flip-content">
                <tr>';
    foreach ($data['head'] as $key=>$row){
    		if(is_array($row)){
    		   if($row['class'])$classDetail='class="'.$row['class'].'"';
    			$ret.='<th width="'.$row['width'].'"'.$classDetail.'>'.$row['content'].'</th>';
    		}else{
                  $ret.='<th class="'.$key.'">'.$row.'</th>';
    		}
    }
                $ret.='</tr></thead><tbody>';
    if($data['item']){
    	$i=0;
    foreach($data['item'] as $row){
       $tr_class='';
       if(is_array($row['tr-attr'])){
          $tr_class=$row['tr-attr']['class'];
          
          $row=$row['item'];
       }
       
        if(is_array($linkArr))$ret.='<tr class="clickable-row '.' '.$tr_class.'" onclick="readDoc('.$linkArr['uri'][$i].')" data-href="'.$linkArr['uri'][$i].'">';
        else $ret.='<tr class="clickable-row '.$tr_class.'">';
        foreach($row as $v){
           if(is_array($v)){
              $col='';
    		   if($v['class'])$classDetail=' class="'.$v['class'].'"';
    		   if($v['col']>1)$col=' colspan="'.$v['col'].'"';
    		   if($v['style'])$col.=' style="'.$v['style'].'"';
    		   else{
    		      //$col='';
    		   }
    			$ret.='<td width="'.$v['width'].'"'.$classDetail.$col.'>'.$v['content'].'</td>';
    		}else{
                  $ret.='<td style="vertical-align:middle; text-align:center;" data-href="'.($linkArr['uri'][$i]?$linkArr['uri'][$i]:"Hello").$linkArr['attr'].'">'.$v.'</td>';
    		}
        }
        $ret.='</tr>';
                  $i++;
    }
    
     if(is_array($linkArr)){
     	$systemFoot.='
     	<style>
     		*[data-href] {
  			cursor: pointer;
			}
			*[data-href] :hover{
  			text-decoration: underline; 
			}
     	</style>
     	<script>
     		function readDoc(id){
     			window.location = "'.$linkArr['url'].'"+id;
     		}
     	</script>
     	';
     }
    
    }
            $ret.='</tbody></table>';
    return $ret;
}

function fileTable($fileData){
    $ret='<table class="table table-hover">';
    $ret.="<tr>";
        foreach($fileData['header'] as $row){
            $ret.="<th>".$row."</th>";
        }
    $ret.="</tr>";
    
    foreach($fileData['item'] as $row){
        $ret.="<tr>";
            foreach($row as $col){
                $ret.="<td style=\"vertical-align:middle\">".$col."</td>";
            }
        $ret.="</tr>";
    }
    
    
    $ret.='</table>';    
    return $ret;
}

