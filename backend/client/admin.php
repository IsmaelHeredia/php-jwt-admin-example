<?php

function admin($dataRequest,$token){  
	$dataRequest = json_encode($dataRequest);	
	$response = execute_secure("http://localhost/jwt/api/protected.php","POST",$dataRequest,$token);
	return $response;		
}	

function execute_secure($url,$method,$dataRequest,$token) {
	$authorization = "Authorization: Bearer ".$token;
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
		'Content-Type: application/json',
		$authorization
	  ),
	));		
	$response = curl_exec($curl);		
	curl_close($curl);	
	return $response;
}

$dataRequest = array (
);

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJUSEVfSVNTVUVSIiwiYXVkIjoiVEhFX0FVRElFTkNFIiwiaWF0IjoxNjA4MzE3Mjg2LCJuYmYiOjE2MDgzMTcyOTYsImV4cCI6MTYwODMxNzM0NiwiZGF0YSI6eyJpZCI6IjEiLCJmaXJzdG5hbWUiOiJhZG1pbiIsImxhc3RuYW1lIjoiYWRtaW4iLCJlbWFpbCI6ImFkbWluQGxvY2FsaG9zdC5jb20ifX0.dSjG2P9xwHIFzl18DJlAHZpN9J-b2Sg99Vs7N1rghK0";

$obj = json_decode(admin($dataRequest,$token));

print_r($obj);

?>