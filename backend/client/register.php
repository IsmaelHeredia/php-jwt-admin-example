<?php

function register($dataRequest){  
	$dataRequest = json_encode($dataRequest);	
	$response = execute("http://localhost/jwt/api/register.php","POST",$dataRequest);
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
  'first_name' => 'admin2',
  'last_name' => 'admin2',
  'email' => 'admin2@localhost.com',
  'password' => 'admin2'
);

$obj = json_decode(register($dataRequest));

print_r($obj);

?>