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
        $query = $this->db->select("SELECT * FROM users WHERE username LIKE :username AND password LIKE :password", array(":username" => $username, ":password" => $password));
        $user = $this->db->fetchObject($query);
        if($user){
            //Sikeres
            $this->loggedUserId = $user->ID;
            $this->loggedUsername = $user->USERNAME;
            $this->jogosultsag = $user->JOGOSULTSAG;
            return 1;
        }else{
            return 100;
        }
    }

    public function signup($username, $password){

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