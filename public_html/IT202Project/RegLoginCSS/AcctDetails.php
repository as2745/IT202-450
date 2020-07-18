
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT count(*) FROM Transactions where Acc_Dst=:acc");
$stmt->execute(array(
	":acc" => $account
));
$res = $stmt->fetchAll();
$e = $stmt->errorInfo();
if($e[0] != "00000"){
	var_dump($e);
	echo "setting eee ".$e."<br>";
}
var_dump($res);
echo "Details of ".$account."<br>";
echo "Hello". $email;?>
