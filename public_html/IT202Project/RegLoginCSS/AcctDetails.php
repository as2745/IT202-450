
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("select * from Transactions where Acc_Dst=:accnum");
$stmt->execute(array(
		    ":accnum" => $name));
$res = $stmt->fetchAll();
var_dump($res);
echo "Details of ".$account.'<br>';
echo "Hello". $email;?>
