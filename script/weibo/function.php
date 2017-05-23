<?php  
	function loginPost($url,$data){
	$tmp = '';
	if(is_array($data)){
	foreach($data as $key =>$value){
	$tmp .= $key."=".$value."&";
	}
	$post = trim($tmp,"&");
	}else{
	$post = $data;
	}
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url); 
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	curl_setopt($ch, CURLOPT_HEADER, 1);   
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
	$return = curl_exec($ch);
	curl_close($ch);
	return $return;
	}
	function httpcurl_r($url){
			global $cookie_arr;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url); 
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_HEADER, 1);  
			curl_setopt($ch, CURLOPT_COOKIE,  implode('; ', $cookie_arr));	
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
			curl_setopt($ch, CURLOPT_AUTOREFERER,1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36'); 
			$result = curl_exec($ch);
			curl_close($ch);
			return $result;
	} 
	function httpscurl($url){
		global $cookie_arr;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_COOKIE,  implode('; ', $cookie_arr));	
		curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36'); 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	} 
?>