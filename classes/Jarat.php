<?php 
require_once('Db.php');
class Jarat{
    public $honnan;
    public $hova;
    public $ar;
    public $erkezes;
    public $indulas;
    public $maxhely;
    private $db;

    public function __construct(){
        $this->db = new Db();
    }

    public function getJaratok(){
        //A kereső formot bele kell rakni majd.
        $query = $this->db->select("SELECT * FROM repulogep");
        $jaratok = Array();
        while($row = $this->db->fetchArray($query)){
            array_push($jaratok,$row);
        }
        return $jaratok;
    }
}


?>