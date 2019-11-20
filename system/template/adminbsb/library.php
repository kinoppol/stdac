<?php
require_once('form.lib.php');

$strMonthFull = array("","มกราคม",
"กุมภาพันธ์",
"มีนาคม",
"เมษายน",
"พฤษภาคม",
"มิถุนายน",
"กรกฎาคม",
"สิงหาคม",
"กันยายน",
"ตุลาคม",
"พฤศจิกายน",
"ธันวาคม");


function gen_sub_menu($arr,$id){
    global $currentURI;
    global $function;
    global $parentActive;
    global $app;
    $ret='';
    $show='';
    foreach($arr as $sub){
        
        if(!$sub['cond']) continue;
                  $sub_url_arr=explode('/',$sub['url']);
                  //print_r();
                  //print $currentURI;
                  if($sub['url']==$currentURI||($app==$sub_url_arr[1]&&$function==$sub_url_arr[2])){
                     
                     if($app==$sub_url_arr[1]&&$function==$sub_url_arr[2]){
                         $show=' show';
                      }
                      if($sub['url']==$currentURI){
                         $subActive='active';
                      }
                      //$subActive='active';
                      
                      $parentActive='active open';
                      //print "ACTIVE".$parentActive;
                  }
                  else $subActive='';
                  
    

                  $ret.='<li class="'.$subActive.'">
                  <a href="'.site_url($sub['url']).'">
                      <i>'.$sub['title'].'</i>
                  </a>
                  '.
                  (is_array($sub['item'])&&count($sub['item'])?gen_sub_menu($sub['item'],$id.$k):'')
                  .'
              </li>
              ';
              }
       $head='<ul id="'.$id.'" class="ml-menu" data-parent="#sidebar-nav">';
       $ret.='</ul>';
    return $head.$ret;
 }

  function gen_main_menu($menu_id=NULL, $menu=array(), $def=NULL,$class='nav nav-list',$title='') {
      global $function;
      global $template;
      global $parentActive;
      global $currentURI;
      global $app;
      global $file;
      $ret='';
      
      foreach($menu as $k=>$grpMenu){
          if(!$grpMenu['cond']) continue;
          $currentURI=$template.'/'.$app.'/'.$function.'/'.$file;
          $subMenu='';
          if(isset($grpMenu['item'])&&count($grpMenu['item'])>0){
              $parentActive='';
              $subMenu.=gen_sub_menu($grpMenu['item'],$k);
              
          }
          //print "> ".$parentActive." | ";
                 //print $grpMenu['title'];
          if($parentActive!=''){
              $activeMenu=$parentActive;
          }else{
              if($grpMenu['url']==$currentURI){
                  $activeMenu='active';
              }else{
                 
                  $activeMenu='';
              }
          }
          //print "->".$activeMenu."<-";
          $ret.='<li class="'.$activeMenu.'">
          ';
          if(isset($grpMenu['item'])&&count($grpMenu['item'])>0){
              $ret.='<a href="javascript:void(0);" class="menu-toggle">
              ';
          }else{
              $ret.='<a href="'.site_url($grpMenu['url']).'">
              ';
          }
          if(isset($grpMenu['bullet']))$ret.='<i class="material-icons '.$grpMenu['color'].'">'.$grpMenu['bullet'].'</i>            ';
          $ret.='<span>'.$grpMenu['title'].'</span>
          ';
          if(isset($grpMenu['item'])&&count($grpMenu['item'])>0){
              $ret.='<b class="menu-toggle"></b>
              ';
          }else{
              $ret.='<b class="arrow"></b>
              ';
          }
          $ret.='</a>'.$subMenu.'</li>';
      }

          $titleMenu=$title?'<li class="header">'.$title.'</li>':'';

      return '<ul class="list">
      '.$titleMenu
      . $ret . '
      </ul>';
  }

  function sHeader($header,$subheader,$class=''){
      $ret='<div class="page-header '.$class.'">
                          <h1>
                              '.$header.'
                          </h1>
                              <p>
                                  '.$subheader.'
                              </p>
                          
                          <div id="systemAlert"></div>
                      </div>';
      return $ret;
  }