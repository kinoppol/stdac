<?php
error_reporting(0);

class pSql{
	public $passphres; 
	public $url; 
	public function __construct($passphres,$url){	
		$this->passphres=$passphres; 
		$this->url=$url;	
	}
	function query($query,$debug=false){	
		if($this->passphres){
		   $key=substr(md5(date('Ydm')),0,4);
			$q=openssl_encrypt(base64_encode($query), 'AES-128-CBC', $key,0,$this->passphres.date('Ydm')); 
		}else{ 
			$q=urlencode($query); 
		}
		$target=$this->url.'?key='.substr(md5(date('Ydm')),0,4).'&q='.$q;
		if($debug)print $target;
		return json_decode(file_get_contents($target));
	}
	function decode($q){
		
		if($this->passphres){
			$result=base64_decode(openssl_decrypt($q, 'AES-128-CBC', $key,0,$this->passphres.date('Ydm')));
		}else{
			$result=preg_replace('/\\\\/', '',urldecode($q));
		}
	}
}