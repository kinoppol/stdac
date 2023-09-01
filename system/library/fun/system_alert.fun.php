<?php
function genAlert($data){
    if(!isset($data['classs']))$data['class']='alert';
    if(!isset($data['color']))$data['color']='alert-info';
    if(!isset($data['icon']))$data['icon']='icon fa fa-info';
    $ret='';
        $ret='<div class="'.$data['class'].' '.$data['color'].' '.$data['class'].'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4><i class="material-icons">'.$data['icon'].'</i><b>'
            .$data['text'].
            '</b></h4></div>';
    return $ret;
}