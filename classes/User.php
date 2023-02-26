<?php 
require_once('Db.php');
class User{
    public $loggedUserId;
    public $loggedUsername;
    public $jogosultsag;
    private $db;

    public function __construct(){
        $this->db = new Db();
    }

    public function signin($username, $password){
        $query = $this->db->select("SELECT * FROM felhasznalo WHERE felhasznalonev LIKE :username AND jelszo LIKE :password", array(":username" => $username, ":password" => $password));
        $user = $this->db->fetchObject($query);
        if($user){
            //Sikeres
            $this->loggedUserId = $user->ID;
            $this->loggedUsername = $user->FELHASZNALONEV;
            $this->jogosultsag = $user->JOGOSULTSAG;
            return 1;
        }else{
            return 100;
        }
    }

    public function signup($username, $password){
        $check_user_query = $this->db->select("SELECT felhasznalonev FROM felhasznalo WHERE felhasznalonev = :username",array(":username" => $username));
        $result = $this->db->fetchAll($check_user_query);
        $rows = $this->db->numRows($check_user_query);
        if($rows == 0){
            //autoincrement id-t meg kell nézni.
            $signup = $this->db->insert("felhasznalo",array("felhasznalonev"=> ":username","jelszo" => ":password","jogosultsag" => ":jogosultsag"), array(":username" => $username, ":password" => $password, ":jogosultsag" => 0));
            return $signup;
        }else{
            //Létezik ilyen felhasználónév már.
            return false;
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    public function loggedUserId(){
        return $this->loggedUserId;
    }

    public function loggedUsername(){
        return $this->loggedUsername;
    }

    public function loggedUserJogosultsag(){
        return $this->jogosultsag;
    }
}


?>