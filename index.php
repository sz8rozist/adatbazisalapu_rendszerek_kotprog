<?php
require_once("init.php");
$func = new Functions();
$func->printHtml("html/header.html");
$func->navbar();
$func->printHtml("html/searchSection.html");
$func->printHtml("html/footer.html");