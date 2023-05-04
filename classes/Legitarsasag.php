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
            $insert = $this->db->insert("legitarsasag", array("nev" => ":nev", "img" => ":img"), array(":nev" => $nev, ":img" => $imgName));
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
        foreach ($search as $key => $value) {
            if (!is_null($value) && $key != "szemely_szam") {
                $conditions .= $key . " = :" . $key . " AND ";
                $bind[":" . $key] = ($key == "indulasi_datum" || $key == "erkezesi_datum") ? date("y-M-d", strtotime($value)) : $value;
            }
        }
        //végéről az AND szó törlése
        $conditions = rtrim($conditions, " AND");
        $query = $this->db->select("SELECT repulo.*, legitarsasag.nev as legitarsasag, legitarsasag.img as logo, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repuloter_id) as indulo_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repuloter_id) as erkezo_repter FROM repulo INNER JOIN legitarsasag ON repulo.legitarsasag_id = legitarsasag.id " . $conditions, $bind);
        $jaratok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($jaratok, $row);
        }
        return $jaratok;
    }

    public function adminPanelJaratok()
    {
        $query = $this->db->select("SELECT repulo.*, legitarsasag.nev as legitarsasag, legitarsasag.img as logo, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repuloter_id) as indulo_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repuloter_id) as erkezo_repter FROM repulo INNER JOIN legitarsasag ON repulo.legitarsasag_id = legitarsasag.id");
        $jaratok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($jaratok, $row);
        }
        return $jaratok;
    }

    public function insertRepulo($model, $osztaly, $max_ferohely, $legitarsasag_id, $indulo_repter_id, $erkezo_repter_id, $indulasi_datum, $indulasi_ido, $erkezesi_datum, $erkezesi_ido, $jegy_ar)
    {
        $msg = "";
        if (empty($model) || empty($osztaly) || empty($max_ferohely) || empty($indulasi_datum) || empty($indulasi_ido) || empty($erkezesi_datum) || empty($erkezesi_ido) || empty($jegy_ar)) {
            $msg = "Minden mező kitöltése kötelező";
        } else {
            if (!is_numeric($max_ferohely) || !is_numeric($jegy_ar)) {
                $msg = "A férőhelyek száma vagy a jegy ár mező hibás";
            } else {
                $insert = $this->db->insert("repulo", array("model" => ":model", "osztaly" => ":osztaly", "indulasi_ido" => ":indulasi_ido", "indulasi_datum" => ":indulasi_datum", "erkezesi_datum" => ":erkezesi_datum", "erkezesi_ido" => ":erkezesi_ido", "legitarsasag_id" => ":legitarsasag_id", "indulo_repuloter_id" => ":indulo_repter_id", "erkezo_repuloter_id" => ":erkezo_repter_id", "max_ferohely" => ":max_ferohely", "jegy_ar" => ":jegy_ar"), array(":model" => $model, ":osztaly" => $osztaly, ":indulasi_ido" => $indulasi_ido, ":indulasi_datum" => date("y-M-d", strtotime($indulasi_datum)), ":erkezesi_datum" => date("y-M-d", strtotime($erkezesi_datum)), ":erkezesi_ido" => $erkezesi_ido, ":legitarsasag_id" => $legitarsasag_id, ":indulo_repter_id" => $indulo_repter_id, ":erkezo_repter_id" => $erkezo_repter_id, ":max_ferohely" => $max_ferohely, ":jegy_ar" => $jegy_ar));
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

    public function editRepulo($model, $osztaly, $max_ferohely, $legitarsasag_id, $indulo_repter_id, $erkezo_repter_id, $indulasi_datum, $indulasi_ido, $erkezesi_datum, $erkezesi_ido, $jegy_ar, $repulo_id)
    {
        $msg = "";
        if (empty($model) || empty($osztaly) || empty($max_ferohely) || empty($indulasi_datum) || empty($indulasi_ido) || empty($erkezesi_datum) || empty($erkezesi_ido) || empty($jegy_ar)) {
            $msg = "Minden mező kitöltése kötelező";
        } else {
            if (!is_numeric($max_ferohely) || !is_numeric($jegy_ar)) {
                $msg = "A férőhelyek száma vagy a jegy ár mező hibás";
            } else {
                $update = $this->db->update("repulo", array("model" => ":model", "osztaly" => ":osztaly", "indulasi_ido" => ":indulasi_ido", "indulasi_datum" => ":indulasi_datum", "erkezesi_datum" => ":erkezesi_datum", "erkezesi_ido" => ":erkezesi_ido", "legitarsasag_id" => ":legitarsasag_id", "indulo_repuloter_id" => ":indulo_repter_id", "erkezo_repuloter_id" => ":erkezo_repter_id", "max_ferohely" => ":max_ferohely", "jegy_ar" => ":jegy_ar"), "id = '" . $repulo_id . "'", array(":model" => $model, ":osztaly" => $osztaly, ":indulasi_ido" => $indulasi_ido, ":indulasi_datum" => date("y-M-d", strtotime($indulasi_datum)), ":erkezesi_datum" => date("y-M-d", strtotime($erkezesi_datum)), ":erkezesi_ido" => $erkezesi_ido, ":legitarsasag_id" => $legitarsasag_id, ":indulo_repter_id" => $indulo_repter_id, ":erkezo_repter_id" => $erkezo_repter_id, ":max_ferohely" => $max_ferohely, ":jegy_ar" => $jegy_ar));
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
        $query = $this->db->select("SELECT repulo.*, legitarsasag.nev as legitarsasag, legitarsasag.img as logo, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.indulo_repuloter_id) as indulo_repter, (SELECT repuloter.nev FROM repuloter WHERE repuloter.id = repulo.erkezo_repuloter_id) as erkezo_repter FROM repulo INNER JOIN legitarsasag ON repulo.legitarsasag_id = legitarsasag.id WHERE repulo.id = :id ", array(":id" => $id));
        return $this->db->fetchObject($query);
    }

    public function getJaratOsztaly()
    {
        $query = $this->db->select("SELECT DISTINCT osztaly FROM repulo");
        $osztalyok = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($osztalyok, $row);
        }
        return $osztalyok;
    }

    public function insertErtekeles($l_id, $f_id, $idopont, $szoveg, $csillag)
    {
        $this->db->insert("ertekeles", array("felhasznalo_id" => ":f_id", "legitarsasag_id" => ":l_id", "idopont" => ":idopont", "szoveg" => ":szoveg", "csillag" => ":csillag"), array(":f_id" => $f_id, ":l_id" => $l_id, ":idopont" => date("y-M-d", strtotime($idopont)), ":szoveg" => $szoveg, ":csillag" => $csillag));
    }

    public function getErtekelesekByUserId($f_id)
    {
        $query = $this->db->select("SELECT ertekeles.*, legitarsasag.nev FROM ertekeles, legitarsasag WHERE ertekeles.legitarsasag_id = legitarsasag.id AND felhasznalo_id = :f_id", array(":f_id" => $f_id));
        $ert = array();
        while ($row = $this->db->fetchArray($query)) {
            $row["IDOPONT"] = date("Y-m-d", strtotime($row["IDOPONT"]));
            array_push($ert, $row);
        }
        return $ert;
    }

    public function deleteErtekeles($id)
    {
        $this->db->delete("ertekeles", "id = :id", array(":id" => $id));
    }

    public function legnepszerubbLegitarsasag()
    {
        $query = $this->db->select("SELECT legitarsasag.nev, ertekeles.csillag FROM legitarsasag INNER JOIN ertekeles ON ertekeles.legitarsasag_id = legitarsasag.id
        WHERE ertekeles.csillag > 4 GROUP BY legitarsasag.nev, ertekeles.csillag FETCH FIRST 10 ROWS ONLY");
        $data = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function legfiatalabbUtazok()
    {
        $query = $this->db->select(" SELECT legitarsasag.nev, MAX(jegy.utas_szulido) as szulido FROM legitarsasag INNER JOIN repulo ON legitarsasag.id = repulo.legitarsasag_id INNER JOIN foglalas ON repulo.id = foglalas.repulo_id INNER JOIN jegy ON foglalas.id = jegy.foglalas_id
GROUP BY legitarsasag.nev");
        $data = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($data, $row);
        }
        return $data;
    }

    public function legidosebbUtazok()
    {
        $query = $this->db->select(" SELECT legitarsasag.nev, MIN(jegy.utas_szulido) as szulido FROM legitarsasag INNER JOIN repulo ON legitarsasag.id = repulo.legitarsasag_id INNER JOIN foglalas ON repulo.id = foglalas.repulo_id INNER JOIN jegy ON foglalas.id = jegy.foglalas_id
GROUP BY legitarsasag.nev");
        $data = array();
        while ($row = $this->db->fetchArray($query)) {
            array_push($data, $row);
        }
        return $data;
    }
}
