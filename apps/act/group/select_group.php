<?php
    $act_id=$hGET['id'];
    $group_id=$hGET['gid'];


    $act_data=sSelectTb($systemDb,'activity','group_id','id='.sQ($act_id));
    $act_data=$act_data[0];
    
    if($act_data['group_id']!=''){
        $groups=json_decode($act_data['group_id'],true);
    }else{
        $groups=array();
    }
    if(!in_array($group_id,$groups)){
        array_push($groups,$group_id);
    }

    $data=array(
        'group_id'=>sQ(json_encode($groups))
    );
    $result=sUpdateTb($systemDb,'activity',$data,'id='.sQ($act_id));
    if($result){
        print "ok";
    }
?>