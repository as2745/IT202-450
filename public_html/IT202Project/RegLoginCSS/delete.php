<?php
include("header.php");
require("common.inc.php");
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$Accnum1 = $_GET["Account_Number"];
//example usage, change/move as needed
$stmt = $db->prepare("SELECT * from Bank_Accounts WHERE Account_Number=:acc");
$stmt->execute(array(
	":acc" => $Accnum1
));
$result=$stmt->fetchall();
if($result[0]["Account_Type"]=="Loan"){
	$stmt1 = $db->prepare("SELECT * from Link_Account WHERE Account_Number=:acc");
	$stmt1->execute(array(
		":acc" => $Accnum1
	));
	$res=$stmt1->fetchall();
	$bal=$res[0]["Balance"];
}
else $bal=$result[0]["Balance"];
if($bal<=0){
$stmt = $db->prepare("UPDATE Bank_Accounts SET Status = 'Inactive' WHERE Account_Number=:acc");
$stmt->execute(array(
	":acc" => $Accnum1
));
} else echo 'Account Balance should be 0 before deactivating. Please transfer or withdraw the reamining balance before deactivating.';
	
?>
