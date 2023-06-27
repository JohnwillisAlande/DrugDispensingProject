<?php
require_once "Connect.php";
   if(isset($_POST)){
      $data = file_get_contents("php://input");
      $user = json_decode($data, true); // return a php array 
      echo json_encode($user['Name']);
   }
   ?>