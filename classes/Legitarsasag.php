<?php
require_once('Db.php');
class Legitarsasag
{
    public $nev;
    public $img;
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function getLegitarsasagok()
    {
        $query = $this->db->select("SELECT * FROM legitarsasag");
        $legitarsasagok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($legitarsasagok, $row);
        }
        return $legitarsasagok;
    }

    public function legitarsasagById($id)
    {
        $query = $this->db->select("SELECT * FROM legitarsasag WHERE id = :id", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function insert($nev, $files = array())
    {
        $msg = "";
        if (empty($nev)) $msg = "Név megadása kötelező!";
        $imgName = NULL;
        if (isset($files["img"]) && !empty($files["img"]["name"])) {
            $imgName = time() . '_' . $files["img"]["name"];
            $target = 'uploads/' . $imgName;
            move_uploaded_file($files["img"]["tmp_name"], $target);
        }
        if (!empty($nev)) {
            $insert = $this->db->insert("legitarsasag", array("id" => ":id", "nev" => ":nev", "img" => ":img"), array(":id" => 2, ":nev" => $nev, ":img" => $imgName));
            if (!$insert) {
                $msg = "Sikertelen hozzáadása";
            }
        }

        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function delete($id)
    {
        $img = $this->db->select("SELECT img FROM legitarsasag WHERE id = :id", array(":id" => $id));
        $row = $this->db->fetchObject($img);
        if (!is_null($row->IMG)) {
            unlink("uploads/" . $row->IMG);
        }
        $this->db->delete("legitarsasag", "id = :id", array(":id" => $id));
    }

    public function update($object, $nev, $files)
    {
        $msg = "";
        if (empty($nev)) $msg = "Név megadása kötelező!";

        $imgName = NULL;
        if (isset($files["img"]) && !empty($files["img"]["name"])) {
            $imgName = time() . '_' . $files["img"]["name"];
            $target = 'uploads/' . $imgName;
            if (!is_null($object->IMG)) {
                unlink("uploads/" . $object->IMG);
            }
            move_uploaded_file($files["img"]["tmp_name"], $target);
        }

        if (!empty($nev)) {
            $update = $this->db->update("legitarsasag", array("nev" => ":nev", "img" => ":img"), "id = '" . $_GET["id"] . "'", array(":nev" => $nev, ":img" => $imgName));
            if (!$update) {
                $msg = "Sikertelen hozzáadása";
            }
        }


        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function getJaratok($search = array())
    {
        $conditions = "WHERE ";
        $bind = array();
        foreach($search as $key => $value){
            if(!is_null($value) && $key != "szemely_szam"){
                $conditions .= $key ." = :" . $key . " AND ";
                $bind[":".$key] = $value;
            }
        }
        //végéről az AND szó törlése
        $conditions = rtrim($conditions, " AND");
        $query = $this->db->select("SELECT repulo.*, legitarsasag.nev as legitarsasag, legitarsasag.img as logo, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repter_id) as indulo_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repter_id) as erkezo_repter FROM repulo INNER JOIN legitarsasag ON repulo.legitarsasag_id = legitarsasag.id ".$conditions,$bind);
        $jaratok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($jaratok, $row);
        }
        return $jaratok;
    }

    public function insertRepulo($model, $osztaly, $max_ferohely, $legitarsasag_id, $indulo_repter_id, $erkezo_repter_id, $indulasi_datum, $indulasi_ido, $erkezesi_datum, $erkezesi_ido)
    {
        //literal does not match format string: Date formátumok ezeket javítani kell az oracle nem támogatja a 0000-00-00 formátumot...
        $msg = "";
        if (empty($model) || empty($osztaly) || empty($max_ferohely) || empty($indulasi_datum) || empty($indulasi_ido) || empty($erkezesi_datum) || empty($erkezesi_ido)) {
            $msg = "Minden mező kitöltése kötelező";
        } else {
            if (!is_numeric($max_ferohely)) {
                $msg = "A férőhelyek száma mező csak számot tartalmazhat";
            } else {
                $insert = $this->db->insert("repulo", array("id" => ":id", "model" => ":model", "osztaly" => ":osztaly", "indulasi_ido" => ":indulasi_ido", "indulasi_datum" => ":indulasi_datum", "erkezesi_datum" => ":erkezesi_datum", "erkezesi_ido" => ":erkezesi_ido", "legitarsasag_id" => ":legitarsasag_id", "indulo_repter_id" => ":indulo_repter_id", "erkezo_repter_id" => ":erkezo_repter_id", "max_ferohely" => ":max_ferohely"), array(':id' => 2,":model" => $model, ":osztaly" => $osztaly, ":indulasi_ido" => $indulasi_ido, ":indulasi_datum" => $indulasi_datum, ":erkezesi_datum" => $erkezesi_datum, ":erkezesi_ido" => $erkezesi_ido, ":legitarsasag_id" => $legitarsasag_id, ":indulo_repter_id" => $indulo_repter_id, ":erkezo_repter_id" => $erkezo_repter_id, ":max_ferohely" => $max_ferohely));
                if (!$insert) {
                    $msg = "Sikertelen hozzáadása";
                }
            }
        }
        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function editRepulo($model, $osztaly, $max_ferohely, $legitarsasag_id, $indulo_repter_id, $erkezo_repter_id, $indulasi_datum, $indulasi_ido, $erkezesi_datum, $erkezesi_ido, $repulo_id)
    {
        $msg = "";
        if (empty($model) || empty($osztaly) || empty($max_ferohely) || empty($indulasi_datum) || empty($indulasi_ido) || empty($erkezesi_datum) || empty($erkezesi_ido)) {
            $msg = "Minden mező kitöltése kötelező";
        } else {
            if (!is_numeric($max_ferohely)) {
                $msg = "A férőhelyek száma mező csak számot tartalmazhat";
            } else {
                $update = $this->db->update("repulo", array("model" => ":model", "osztaly" => ":osztaly", "indulasi_ido" => ":indulasi_ido", "indulasi_datum" => ":indulasi_datum", "erkezesi_datum" => ":erkezesi_datum", "erkezesi_ido" => ":erkezesi_ido", "legitarsasag_id" => ":legitarsasag_id", "indulo_repter_id" => ":indulo_repter_id", "erkezo_repter_id" => ":erkezo_repter_id", "max_ferohely" => ":max_ferohely"), "id = '" . $repulo_id . "'", array(":model" => $model, ":osztaly" => $osztaly, ":indulasi_ido" => $indulasi_ido, ":indulasi_datum" => $indulasi_datum, ":erkezesi_datum" => $erkezesi_datum, ":erkezesi_ido" => $erkezesi_ido, ":legitarsasag_id" => $legitarsasag_id, ":indulo_repter_id" => $indulo_repter_id, ":erkezo_repter_id" => $erkezo_repter_id, ":max_ferohely" => $max_ferohely));
                if (!$update) {
                    $msg = "Sikertelen szerkesztés";
                }
            }
        }
        $response = [
            "msg" => $msg
        ];
        return json_encode($response);
    }

    public function deleteRepulo($repulo_id)
    {
        $this->db->delete("repulo", "id = :id", array(":id" => $repulo_id));
    }

    public function getRepuloById($id)
    {
        $query = $this->db->select("SELECT repulo.*, legitarsasag.nev as legitarsasag, legitarsasag.img as logo, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repter_id) as indulo_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repter_id) as erkezo_repter FROM repulo INNER JOIN legitarsasag ON repulo.legitarsasag_id = legitarsasag.id WHERE repulo.id = :id ", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function getJaratOsztaly(){
        $query = $this->db->select("SELECT osztaly FROM repulo");
        $osztalyok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($osztalyok, $row);
        }
        return $osztalyok;
    }
}
