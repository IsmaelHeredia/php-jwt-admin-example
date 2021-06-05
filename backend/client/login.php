<?php

function login($dataRequest){  
	$dataRequest = json_encode($dataRequest);	
	$response = execute("http://localhost/jwt/api/login.php","POST",$dataRequest);
	return $response;		
}	

function execute($url,$method,$dataRequest) {
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => $method,
	  CURLOPT_POSTFIELDS =>$dataRequest,
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));		
	$response = curl_exec($curl);		
	curl_close($curl);	
	return $response;
}

$dataRequest = array (
  'email' => 'admin@localhost.com',
  'password' => 'admin'
);

$obj = json_decode(login($dataRequest));

print_r($obj);

?>