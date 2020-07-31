<?php

include("header.php");
require("common.inc.php");
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$name = $_GET['email'];
//example usage, change/move as needed
$stmt = $db->prepare("UPDATE User SET Active = 'No' WHERE email=:acc");
$stmt->execute(array(
	":acc" => $name
));
?>
