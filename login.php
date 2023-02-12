<?php
require_once("init.php");
$user = new User();

if(isset($_POST["username"]) && isset($_POST["password"])){
    $result = $user->signin($_POST["username"], $_POST["password"]);
    if($result == 1){
        $_SESSION["login"] = true;
        $_SESSION["id"] = $user->loggedUserId();
        $_SESSION["username"] = $user->loggedUsername;
        $_SESSION["jogosultsag"] = $user->jogosultsag;
        if($user->jogosultsag == 1){
            echo json_encode(array("succes" => true, "location" => "dashboard.php"));
        }else{
            echo json_encode(array("succes" => true, "location" => "index.php"));
        }
    }else if($result == 100){
        //Error
        echo json_encode(array("succes" => false, "location" => ""));

    }
}