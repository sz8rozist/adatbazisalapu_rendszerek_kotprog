<?php
require_once("init.php");
$func = new Functions();
if(empty($_SESSION)) header("location: index.php");

$func->printHtml("html/header.html");
$func->dashboardNavbar();
$func->printHtml("html/admin.dashboard.html");
$func->printHtml("html/footer.html");
