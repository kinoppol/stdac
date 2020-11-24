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
		$target=$this->url.'?key='.substr(md5(date('Ydm').$key),0,4).'&q='.$q;
		if($debug)print $target;
		return json_decode(file_get_contents($target));
	}
	function decode($q){
		
		if($this->passphres=$passphres){
			$result=base64_decode(openssl_decrypt($q, 'AES-128-CBC', $key,0,$this->passphres.date('Ydm')));
		}else{
			$result=preg_replace('/\\\\/', 
'',urldecode($q));
		}
		return $result;
    }
}

$key_list=array(
    'rms'=>array(
        'key'=>'0dc36f73fbfc102d83a01a521e42cf2d',
        'function'=>'select',
    )
);


function ac($q,$api_id,$api_key,$key_list){
    $q=explode(' ',$q);

    $available_function=explode(',',$key_list[$api_key]);


}


$api_query=new psql(); 
$query=$api_query->decode($_GET['q']);
$data=$db->query($query);