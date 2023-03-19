<?php
require_once('Db.php');
class Jegy
{
    public $fizetve;
    public $fizetesi_mod;
    public $repulo_id;
    public $felhasznalo_id;

    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function insert($booking)
    {
        $msg = "";
        $jegy_insert = $this->db->insert("foglalas", array("fizetve" => ":fizetve", "fizetes_mod" => ":fizetes_mod", "repulo_id" => ":repulo_id", "felhasznalo_id" => ":felhasznalo_id"), array(":fizetve" => "0", ":fizetes_mod" => $booking["fizetes_mod"], ":repulo_id" => $booking["repulo_id"], ":felhasznalo_id" => $booking["felhasznalo_id"]));
        if (!$jegy_insert) {
            $msg = "Sikertelen jegy hozzáadás";
        }
        $jegy_id = $this->db->select("SELECT MAX(id) as max_jegy_id FROM foglalas");
        $jegy_id = $this->db->fetchObject($jegy_id);
        $ar = $booking["ar"];
        foreach ($booking as $key => $value) {
            if (is_array($value)) {
                $this->db->insert("jegy", array("utas_kernev" => ":utas_kernev", "utas_veznev" => ":utas_veznev", "utas_szulido" => ":utas_szulido", "ules" => ":ules", "ar" => ":ar", "foglalas_id" => ":foglalas_id"), array(":utas_kernev" => $value["utas_kernev"], ":utas_veznev" => $value["utas_veznev"], ":utas_szulido" => date("y-M-d", strtotime($value["utas_szulido"])), ":ules" => $value["ules"], ":ar" => $ar, ":foglalas_id" => $jegy_id->MAX_JEGY_ID));
            }
        }
        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function getLefoglaltUlohelyek($repulo_id)
    {
        $query = $this->db->select("SELECT jegy.ules FROM jegy, foglalas WHERE jegy.foglalas_id = foglalas.id AND foglalas.repulo_id = :repulo_id", array(":repulo_id" => $repulo_id));
        $ulesek = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($ulesek, $row["ULES"]);
        }
        return $ulesek;
    }

    public function getFoglalasok()
    {
        $query = $this->db->select("SELECT foglalas.*, repulo.indulasi_ido, repulo.erkezesi_ido, repulo.indulasi_datum, repulo.erkezesi_datum, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repuloter_id) as indulasi_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repuloter_id) as erkezo_repter FROM foglalas, repulo WHERE foglalas.repulo_id = repulo.id");
        $foglalasok = array();
        while ($row = $this->db->fetchArray($query)) {
            $row["ERKEZESI_DATUM"] = date("Y-m-d", strtotime($row["ERKEZESI_DATUM"]));
            $row["INDULASI_DATUM"] = date("Y-m-d", strtotime($row["INDULASI_DATUM"]));
            array_push($foglalasok, $row);
        }
        return $foglalasok;
    }

    public function getFoglalasAdatok($jegy_id)
    {
        $query = $this->db->select("SELECT * FROM jegy WHERE foglalas_id = :foglalas_id", array(":foglalas_id" => $jegy_id));
        $foglalasok = array();
        while ($row = $this->db->fetchArray($query)) {
            $row["UTAS_SZULIDO"] = date("Y-m-d", strtotime($row["UTAS_SZULIDO"]));
            array_push($foglalasok, $row);
        }
        return $foglalasok;
    }

    public function fizetve($jegy_id)
    {
        $this->db->update("foglalas", array("fizetve" => ":fizetve"), "id = '" . $jegy_id . "'", array(":fizetve" => "1"));
    }

    public function deleteJegy($jegy_id)
    {
        $this->db->delete("foglalas", "id = :id", array(":id" => $jegy_id));
    }

    public function deleteJegyAdat($id)
    {
        $this->db->delete("jegy", "id = :id", array(":id" => $id));
    }

    public function getJegyAdatok($id)
    {
        $query = $this->db->select("SELECT * FROM jegy WHERE id = :id", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function updateJegy_adatok($jegy_adatok_id, $utas_veznev, $utas_kernev, $utas_szulido, $becsekkolas)
    {
        if (!empty($utas_veznev) && !empty($utas_kernev) && !empty($utas_szulido)) {
            $update = $this->db->update("jegy_adatok", array("utas_veznev" => ":utas_veznev", "utas_kernev" => ":utas_kernev", "utas_szulido" => ":utas_szulido", "becsekkolas" => ":becsekkolas"), "id = '" . $jegy_adatok_id. "'", array(":utas_veznev" => $utas_veznev, ":utas_kernev" => $utas_kernev, ":utas_szulido" => date("y-M-d", strtotime($utas_szulido)), ":becsekkolas" => $becsekkolas));
            if (!$update) {
                $msg = "Sikertelen szerkesztés";
            }
        }else{
            $msg = "Minden mező kitöltése kötelező!";
        }


        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function insertJegyAdatok($jegy_id,$utas_veznev, $utas_kernev, $utas_szulido, $becsekkolas, $ar){
        if (!empty($utas_veznev) && !empty($utas_kernev) && !empty($utas_szulido)) {
            $insert = $this->db->insert("jegy_adatok", array("utas_veznev" => ":utas_veznev", "utas_kernev" => ":utas_kernev", "utas_szulido" => ":utas_szulido", "becsekkolas" => ":becsekkolas", "jegy_id" => ":jegy_id", "ar" => ":ar"), array(":utas_veznev" => $utas_veznev, ":utas_kernev" => $utas_kernev, ":utas_szulido" => date("y-M-d", strtotime($utas_szulido)), ":becsekkolas" => $becsekkolas, ":jegy_id" => $jegy_id, ":ar" => $ar));
            if (!$insert) {
                $msg = "Sikertelen hozzáadás";
            }
        }else{
            $msg = "Minden mező kitöltése kötelező!";
        }

        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function getJegyAr($jegy_id){
        $query = $this->db->select("SELECT repulo.jegy_ar FROM repulo, jegy, jegy_adatok WHERE jegy.repulo_id = repulo.id AND jegy_adatok.jegy_id = jegy.id AND jegy.id = :jegy_id", array(":jegy_id" => $jegy_id));
        $obj = $this->db->fetchObject($query);
        return $obj->JEGY_AR;

    }
}
