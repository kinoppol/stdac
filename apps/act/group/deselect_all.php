<?php
    $act_id=$hGET['id'];
    $group_id=$hGET['gid'];


    $data=array(
        'group_id'=>sQ('')
    );
    $result=sUpdateTb($systemDb,'activity',$data,'id='.sQ($act_id));
    if($result){
        print "ok";
    }
?>