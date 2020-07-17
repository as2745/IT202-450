
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$new_arr = array_column($accounts,'Account_Number');
echo "Details of ".$account;
echo "Hello". $email;?>
