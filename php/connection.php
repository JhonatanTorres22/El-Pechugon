<?php

if(session_status() == PHP_SESSION_NONE){
	session_start();
}

date_default_timezone_set('America/Lima');

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "restaurante";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);