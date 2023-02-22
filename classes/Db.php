<?php 

class Db {

    private $con;
    private $host = "localhost/xe";
    private $username = "SYSTEM";
    private $password = "oracle";
    private $execute_status = false;

    function __construct() {
        try {
            $this->con = oci_connect($this->username, $this->password,$this->host);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function select($sql, $bind = false){
        return $this->execute($sql, $bind);
    }

    private function execute($sql, $bind = false){
        $stid = oci_parse($this->con, $sql);
        if($bind && is_array($bind)){
            foreach($bind as $key => $value){
                oci_bind_by_name($stid, $key, $bind[$key]);
            }
        }
        $this->execute_status = oci_execute($stid);
        return $this->execute_status ? $stid : false;
    }

    public function insert($table, $array, $bind = false){
        if(empty($array)) return false;
        $fields = array();
        $values = array();
        foreach($array as $key => $value){
            $fields[] = $key;
            $values[] = $value;
        }
        $fields = implode(",",$fields);
        $values = implode(",",$values);
        $sql = "INSERT INTO $table ($fields) VALUES($values)";
        $result = $this->execute($sql, $bind);
        return $result === false ? false : $result;
    }

    public function delete($table, $condition, $bind = false){
        $sql = "DELETE FROM $table WHERE $condition";
        $result = $this->execute($sql,$bind);
        return $result === false ? false : $result;
    }

    public function update($table, $array, $condition, $bind = false){
        if(empty($array)) return false;
        $values = array();
        foreach($array as $key => $value){
            $val[] = $key . " = " . $value;
        }
        $values =  implode(", ", $val);
        $sql = "UPDATE $table SET $values WHERE $condition";
        $result = $this->execute($sql, $bind);
        return $result === false ? false : $result;
    }

    public function fetchAll($statement){
        return oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    }

    public function fetchArray($statement){
        return oci_fetch_array($statement, OCI_ASSOC);
    }

    public function fetchObject($statement){
        return oci_fetch_object($statement);
    }

    public function numRows($statement){
        return oci_num_rows($statement);
    }
}

