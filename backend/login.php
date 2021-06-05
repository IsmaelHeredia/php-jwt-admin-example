<?php

require "./security.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$security = new Security();

$data = json_decode(file_get_contents("php://input"));

$user = $data->user;
$password = $data->password;

$login = $security->login($user,$password);

if($login != null) {
    echo json_encode(
        array(
            "status" => 1,
            "message" => "Login OK",
    ));
} else {
    http_response_code(401);
    echo json_encode(array("status"=>0, "message" => "Bad login"));
}

?>