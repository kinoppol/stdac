<?php
    $act_id=$hGET['id'];
    $group_id=$hGET['gid'];


    $group_data=sSelectTb($systemDb,'group','group_id');
    $groups=array();
    foreach($group_data as $group){
        array_push($groups,$group['group_id']);
    }
    

    $data=array(
        'group_id'=>sQ(json_encode($groups))
    );
    $result=sUpdateTb($systemDb,'activity',$data,'id='.sQ($act_id));
    if($result){
        print "ok";
    }
?>