<?php

include_once "config/database.php";
require "vendor/autoload.php";

use \Firebase\JWT\JWT;

JWT::$leeway = 60;

class Security {
  
   public function __construct(){
      $this->cookie_name = "jwt_cookie";
      $this->secret_key = "YOUR_SECRET_KEY";
   }

   public function login($user,$password) {
      $databaseService = new DatabaseService();
      $conn = $databaseService->getConnection();

      $query = "SELECT id, user, password FROM users WHERE user = ? LIMIT 0,1";

      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $user);
      $stmt->execute();
      $num = $stmt->rowCount();
      
      if($num > 0){
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          $id = $row["id"];
          $user = $row["user"];
          $password2 = $row["password"];
      
          if(password_verify($password, $password2))
          {
              $secret_key = $this->secret_key;
              $issuer_claim = "THE_ISSUER";
              $audience_claim = "THE_AUDIENCE";
              $issuedat_claim = time();
              $notbefore_claim = $issuedat_claim + 10;
              $expire_claim = $issuedat_claim + 3600;
              $token = array(
                  "iss" => $issuer_claim,
                  "aud" => $audience_claim,
                  "iat" => $issuedat_claim,
                  "nbf" => $notbefore_claim,
                  "exp" => $expire_claim,
                  "data" => array(
                      "id" => $id,
                      "user" => $user,
              ));
      
              http_response_code(200);
      
              $jwt = JWT::encode($token, $secret_key);
      
              setcookie($this->cookie_name, $jwt, time()+3600, "/jwt", "", false, false);
      
              /*
              setcookie("jwt_cookie", $jwt, [
                  "expires" => time() + 3600,
                  "path" => "/jwt",
                  "domain" => "",
                  "secure" => true,
                  "httponly" => true,
                  "samesite" => "strict"
              ]);
              */

              return true;
          }
          else{
             return false;
          }
      } else {
         return false;
      }

   }

   public function checkToken() {

      if(isset($_COOKIE[$this->cookie_name])) {
         $jwt = $_COOKIE[$this->cookie_name];

         $secret_key = $this->secret_key;
         
         if($jwt){
            try {
               $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
               $id = $decoded->data->id;
               $user = $decoded->data->user;
               return array($id,$user);
            } catch (Exception $e){
               return null;
            }
         } else {
            return null;
         }
      } else {
         return null;
      }
   }

   public function removeToken() {
      if (isset($_COOKIE[$this->cookie_name])) {
         unset($_COOKIE[$this->cookie_name]); 
         setcookie($this->cookie_name, null, -1, "/jwt"); 
         return true;
      } else {
         return false;
     }
   }

}