<?php 
require_once('Db.php');
class Jegy{
    public $fizetve;
    public $fizetesi_mod;
    public $repulo_id;
    public $felhasznalo_id;

    private $db;

    public function __construct(){
        $this->db = new Db();
    }
    

    /**
     * Get the value of fizetve
     */ 
    public function getFizetve()
    {
        return $this->fizetve;
    }

    /**
     * Set the value of fizetve
     *
     * @return  self
     */ 
    public function setFizetve($fizetve)
    {
        $this->fizetve = $fizetve;

        return $this;
    }

    /**
     * Get the value of fizetesi_mod
     */ 
    public function getFizetesi_mod()
    {
        return $this->fizetesi_mod;
    }

    /**
     * Set the value of fizetesi_mod
     *
     * @return  self
     */ 
    public function setFizetesi_mod($fizetesi_mod)
    {
        $this->fizetesi_mod = $fizetesi_mod;

        return $this;
    }

    /**
     * Get the value of repulo_id
     */ 
    public function getRepulo_id()
    {
        return $this->repulo_id;
    }

    /**
     * Set the value of repulo_id
     *
     * @return  self
     */ 
    public function setRepulo_id($repulo_id)
    {
        $this->repulo_id = $repulo_id;

        return $this;
    }

    /**
     * Get the value of felhasznalo_id
     */ 
    public function getFelhasznalo_id()
    {
        return $this->felhasznalo_id;
    }

    /**
     * Set the value of felhasznalo_id
     *
     * @return  self
     */ 
    public function setFelhasznalo_id($felhasznalo_id)
    {
        $this->felhasznalo_id = $felhasznalo_id;

        return $this;
    }
}
