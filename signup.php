<?php
require_once("init.php");
$user = new User();

if(isset($_POST["username"]) && isset($_POST["password"])){
    $succes = true;
    $msg = "";
    $result = $user->signup($_POST["username"], $_POST["password"]);
    if($result){
        //sikeres
        $msg = "Sikeres Regisztráció";
    }else{
        //foglalt felhasználónév
        $msg = "Ez a felhasználónév már foglalt";
        $succes = false;
    }

    echo json_encode(array("status" => $succes, "msg" => $msg));
}