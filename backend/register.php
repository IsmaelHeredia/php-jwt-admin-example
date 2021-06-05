<?php

include_once './config/database.php';

$user = "admin";
$password = "admin";
$conn = null;

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$table_name = "users";

$query = "INSERT INTO " . $table_name . "
                SET user = :user,
                    password = :password";

$stmt = $conn->prepare($query);

$stmt->bindParam(":user", $user);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);

if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "User created"));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Error making user"));
}
?>