
<?php
class pSql{
public $passphres;
public $url;
public function __construct($passphres,$url){
$this->passphres=$passphres;
$this->url=$url;
}
function query($query,$debug=false){
if($this->passphres=$passphres){
$q=openssl_encrypt(base64_encode($query), 'AES-128-CBC', $key,0,$this->passphres.date('Ydm'));
}else{
$q=urlencode($query);
}
$target=$this->url.'?key='.substr(md5(date('Ydm')),0,4).'&q='.$q;
if($debug)print $target;
$jsData=trim(file_get_contents($target));
$data=json_decode(jsonTrim($jsData),true);
return $data;
}
function decode($q){

if($this->passphres=$passphres){
$result=base64_decode(openssl_decrypt($q, 'AES-128-CBC', $key,0,$this->passphres.date('Ydm')));
}else{
$result=urldecode($q);
}
return $result;
}
}

function jsonTrim($js){
if(strlen($js)==0)return '';
if(substr($js,0,1)=='{'&&substr($js,strlen($js)-1,1)=='}')return $js;
else{
if(substr($js,0,1)!='{')$js=substr($js,1,strlen($js));
if(substr($js,strlen($js)-1,1)!='}')$js=substr($js,0,strlen($js)-1);

$js=jsonTrim($js);
return $js;
}
}


function rms_get_data($rmsurl,$app_name,$data){
    $target_url=$rmsurl."/api_connection.php?data=".$data."&app_name=".$app_name;
    $rawdata=file_get_contents($target_url);
    $json=json_decode($rawdata,false);
    return $json;
}
