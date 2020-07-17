<?php
include("header.php");

?>
<h4>Home</h4>
<?
require("common.inc.php");
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>
