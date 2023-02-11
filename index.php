<?php
require_once("classes/Db.php");
$db = new Db();
$query = $db->select("SELECT * FROM teszt");
$res = $db->fetchArray($query);
var_dump($res);
echo file_get_contents("html/header.html");
echo file_get_contents("html/navbar.html");
echo file_get_contents("html/searchSection.html");
echo file_get_contents("html/footer.html");