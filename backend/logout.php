<?php

require "./security.php";

$security = new Security();

if($security->checkToken()) {
    if($security->removeToken()) {
        echo json_encode(
            array(
                "status" => 1,
                "message" => "Logout OK",
        ));
    } else {
        http_response_code(401);
        echo json_encode(array("status"=>0, "message" => "Bad logout"));
    }
}

?>