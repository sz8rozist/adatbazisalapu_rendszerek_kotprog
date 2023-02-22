<?php 
require_once('Db.php');
class Poggyasz{
    public $elnevezes;
    public $suly;
    public $meret;
    public $ar;
    private $db;

    public function __construct(){
        $this->db = new Db();
    }

    public function getPoggyaszok(){
        $query = $this->db->select("SELECT * FROM poggyasz");
        $repterek = Array();
        while($row = $this->db->fetchArray($query)){
            array_push($repterek,$row);
        }
        return $repterek;
    }

    public function getPoggyaszById($id){
        $query = $this->db->select("SELECT * FROM poggyasz WHERE id = :id", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function delete($id){
        $this->db->delete("poggyasz","id = :id",array(":id" => $id));
    }

    public function update($id, $elnevezes, $suly, $meret, $ar){
        $msg = "";
        if(empty($elnevezes) || empty($suly) || empty($meret) || empty($ar)){
            $msg = "Minden mező kitöltése kötelező!";
        }else{
            if(!is_numeric($ar)){
                $msg = "Az árnak számnak kell lennie!";
            }else{
                $update = $this->db->update("poggyasz",array("elnevezes"=> ":elnevezes","suly" => ":suly", "meret" => ":meret", "ar" => ":ar"), "id = '".$id."'",array(":elnevezes" => $elnevezes, ":suly" => $suly, ":meret" => $meret, ":ar" => $ar));
                if(!$update){
                    $msg = "Sikertelen szerkesztés";
                }
            }
        }

        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function insert($elnevezes, $suly, $meret, $ar){
        $msg = "";
        if(empty($elnevezes) || empty($suly) || empty($meret) || empty($ar)){
            $msg = "Minden mező kitöltése kötelező!";
        }else{
            if(!is_numeric($ar)){
                $msg = "Az árnak számnak kell lennie!";
            }else{
                $insert = $this->db->insert("poggyasz",array("id" => ":id","elnevezes"=> ":elnevezes","suly" => ":suly", "meret" => ":meret", "ar" => ":ar"), array(":id" => 1,":elnevezes" => $elnevezes, ":suly" => $suly, ":meret" => $meret, ":ar" => $ar));
                if(!$insert){
                    $msg = "Sikertelen hozzáadása";
                }
            }
        }
        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }
}
