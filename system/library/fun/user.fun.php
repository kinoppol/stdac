<?php
  function signInUser($userID,$remember=false,$noRedirect=false){
    global $systemDb;
          $data=sSelectTb($systemDb,'userdata','*','id="'.$userID.'" AND active="Y" limit 1');
          $userdata=$data[0];
  
  //$groups=$userdata['groups'];
  
  //print_r($groups); 
  
  
  	//$accession=accession_gen($groups);
  	//print_r($accession);
  $email=$userdata['email'];
  //print $academy_id; exit();
  $picture_file=$email;
  $pictureProfile = BASE_PATH."system/pictures/profile/".$email.".png";
  $new_pictureProfile = BASE_PATH."system/pictures/profile/".$userdata['user_picture'];
  if(!file_exists($pictureProfile)&&!file_exists($new_pictureProfile)){
      $picture= site_url("system/pictures/profile/noimage.png",true);
  }else{
     if(file_exists($new_pictureProfile)){
      $picture= site_url("system/pictures/profile/".$userdata['user_picture'],true);
      $picture_file=$userdata['user_picture'];
     }else{
      $picture= site_url("system/pictures/profile/".$email.".png",true);
      $picture_file.='.png';
     }
      
  }
  
  $time_logon=60*60;
  if($remember){
  	 $time_logon=60*60*24*365;
  }
  
	$logon_data=$userdata;
  $logon_data["time_logon"]=$time_logon;
  $personal_data=sSelectTb($systemDb,'personal','*','id='.$logon_data['personal_id']);
  $personal_data=$personal_data[0];

  
  $logon_data["fname"]=$personal_data['fname'];
  $logon_data["lname"]=$personal_data['lname'];
	//$logon_data["picture"]=$picture;
	//$logon_data["picture_file"]=$picture_file;
	//$logon_data["accession"]=$accession;
  //                 print_r($logon_data);
                   
  if(user_logon($logon_data)){
  
      if($remember){
          setcookie('last_user',serialize($logon_data), time() + (60*60*24*365), "/");
      }else{
          setcookie('last_user','', time() + 60*60*24*365, "/");
      }/*
      if($academy_id!=''){
          //print "AC ID =>> ".$academy_id; exit();
                selectAcademy($academy_id); 
         }
         */
         if(!$noRedirect){
            if($default_uri){
              redirect($default_uri);
            }else{
              
              redirect(site_url('main/home/dashboard/view'),true);
              //exit();
            }
        }else{
        //  print_r($_COOKIE);
        }
  }
         
  }
  
 
   $group_arr=array();
  function accession_gen($groups){
     
   global $group_arr;
  	$ret="";
  	//print $groups;
  	$arr_grp=explode(',',$groups);
  	foreach($arr_grp as $grp){
  		//print $grp;
  		
  		$acs=grp_tree($grp);
  		if($acs!=''&&$ret!='')$ret.=','.$acs;
  		else $ret.=$acs;
  	}
  	//print 555;
  	//print $ret;
  	
  	$ret=array_unique(explode(',',$ret));
  	//print_r($ret);
  	//exit();
  	return json_encode($ret);
  }
  
  function grp_tree($grp_id){
   global $group_arr;
   if(!is_array($group_arr))$group_arr=array();
  	$ret='';
  	$grp_access=selectTb('usergroup','parent_group,group_accession','id='.$grp_id);
  	$ret=$grp_access[0]['group_accession'];
  	array_push($group_arr,$grp_id);
  	if($grp_access[0]['parent_group']!=0&&(!in_array($grp_access[0]['parent_group'],$group_arr))){
  	   
  		$acs=grp_tree($grp_access[0]['parent_group']);
  		if($acs!=''&&$ret!='')$ret.=",".$acs;
  		else $ret.=$acs;
  	}
  	return $ret;
  }
  
  function user_logon($logon_data){
    global $systemDb;
    //print_r($logon_data);
    setcookie('user',serialize($logon_data), time() + $logon_data['time_logon'], "/");
    //print_r($_COOKIE);
    return sUpdateTb($systemDb,"userdata",array("last_login"=>"NOW()"),"id=".$logon_data['id'],true);
  }
  
  function current_user($key){
      if(isset($_COOKIE['user']))$user_data=unserialize($_COOKIE['user']);
    //print_r($user_data);
      if(!isset($user_data['id']))return 0;
      return $user_data[$key];
  }
  
  function update_current_user($data){
      if(isset($_COOKIE['user']))$user_data=unserialize($_COOKIE['user']);
    //print_r($user_data);
      if(!isset($user_data['user_id']))return 0;
      foreach($data as $key=>$val){
      $user_data[$key]=$val;
      }

      setcookie('user',serialize($user_data),time() + 60*60*4, "/");
      return $user_data[$key];
  }
  
  function last_user($key){
      if(isset($_COOKIE['last_user']))$user_data=unserialize($_COOKIE['last_user']);
    //print_r($user_data);
      if(!isset($user_data['user_id']))return 0;
      return $user_data[$key];
  }
  
  function user_logoff(){
    setcookie('user','', time() + current_user('logon_time'), "/");
    $_SESSION['access_token']="";
    $_SESSION['google_data']="";
    $_SESSION['google_code']="";
    $_SESSION['DB2']="";
  }
  
  function add_user($user_data,$debug=false){
    global $sacdb;
    global $prefix;
    //print $prefix;
    $password=md5($user_data['password']);
    $data=array(
      'username'=>'"'.$user_data["email"].'"',
      'password'=>'"'.$password.'"',
      'name'=>'"'.$user_data["name"].'"',
      'surname'=>'"'.$user_data["surename"].'"',
      'email'=>'"'.$user_data["email"].'"',
      'signup'=>'NOW()',
      'last_login'=>'NOW()',
      'mobile'=>'"'.$user_data["mobile"].'"',
      'accession'=>'\''.$user_data["accession"].'\'',
      'active'=>'"'.$user_data["active"].'"',
      'default_uri'=>'"'.$user_data["default_uri"].'"',
      );
    $result =insertTb('userdata',$data,$debug);
    //$query = "insert into {$prefix}userdata (username,password,name,surname,email,signup,last_login,mobile,accession,active)";
    //$query.=" values ('{$user_data["email"]}','{$password}','{$user_data["name"]}','{$user_data["surname"]}','{$user_data["email"]}',NOW(),NOW(),'{$user_data["mobile"]}','{$user_data["accession"]}','{$user_data['active']}')";
    //if($debug)print $query;
    //$result = mysqli_query($sacdb, $query);
    //print_r($result);
    //print $query;
    if($result){
        return mysqli_insert_id($sacdb);
    }
  }
  
  function checkPassword($user_id=NULL,$password=NULL){
    if(!isset($user_id)||!isset($password))return false;
    
    $userdata=selectTb('userdata','count(*)','user_id='.$user_id.' AND password="'.md5($password).'"  limit 1');
    if($userdata[0]['count(*)']!=1)return false;
    else return true;
    
  }
  
  function changePassword($user_id=NULL,$newPassword=NULL){
    //if(!isset($user_id)||!isset($newPassword))return false;
    $data=array(
      'password'=>"'".md5($newPassword)."'",
      );
    $updatePassword=updateTb('userdata',$data,'user_id='.$user_id.'  limit 1');

    return $updatePassword;
    
  }

  function check_user_pass($username,$password){
    global $systemDb;
          $data=sSelectTb($systemDb,'userdata','id','username='.sQ($username).' AND password='.sQ(md5($password)).' AND active="Y" limit 1');
          $userCount=count($data);
          if($userCount==1){
            return $data[0]['id'];
          }else{
            return false;
          }
  }
