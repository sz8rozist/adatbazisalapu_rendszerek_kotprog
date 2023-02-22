<?php 
require_once('Db.php');
class Repuloter{
    public $nev;
    public $varos;
    public $orszag;
    private $db;

    public function __construct(){
        $this->db = new Db();
    }

    public function getRepterek(){
        $query = $this->db->select("SELECT * FROM repuloter");
        $repterek = Array();
        while($row = $this->db->fetchArray($query)){
            array_push($repterek,$row);
        }
        return $repterek;
    }

    public function getRepterById($id){
        $query = $this->db->select("SELECT * FROM repuloter WHERE id = :id", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function delete($id){
        $this->db->delete("repuloter","id = :id",array(":id" => $id));
    }

    public function update($id, $nev, $varos, $orszag){
        $msg = "";
        if(empty($nev) || empty($varos) || empty($orszag)){
            $msg = "Minden mező kitöltése kötelező!";
        }else{
            $update = $this->db->update("repuloter",array("nev"=> ":nev","varos" => ":varos", "orszag" => ":orszag"), "id = '".$id."'" ,array(":nev" => $nev, ":varos" => $varos, ":orszag" => $orszag));
            if(!$update){
                $msg = "Sikertelen hozzáadása";
            }
        }

        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function insert($nev, $varos, $orszag){
        $msg = "";
        if(empty($nev) || empty($varos) || empty($orszag)){
            $msg = "Minden mező kitöltése kötelező!";
        }else{
            $insert = $this->db->insert("repuloter",array("id" => ":id","nev"=> ":nev","varos" => ":varos", "orszag" => ":orszag"), array(":id" => 1,":nev" => $nev, ":varos" => $varos, ":orszag" => $orszag));
            if(!$insert){
                $msg = "Sikertelen hozzáadása";
            }
        }
        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function getVarosok(){
        $query = $this->db->select("SELECT id,varos FROM repuloter");
        $varosok = Array();
        while($row = $this->db->fetchArray($query)){
            array_push($varosok,$row);
        }
        return $varosok;
    }

    public function getJaratVarosByRepterId($repter_id){
        $query = $this->db->select("SELECT varos FROM repuloter WHERE id = :id", array(":id" => $repter_id));
        return $this->db->fetchObject($query);
    }
}
