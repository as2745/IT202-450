
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$email=$_SESSION["user"]["email"];
$account=$_GET["account"];
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$stmt = $db->prepare("SELECT count(*) as num FROM Transactions where Acc_Dst=:acc");
$stmt->execute(array(
	":acc" => $account
));
$res = $stmt->fetchAll();
$e = $stmt->errorInfo();
if($e[0] != "00000"){
	var_dump($e);
	echo "setting eee ".$e."<br>";
}
$num=$res[0]["num"];

$stmt1 = $db->prepare("SELECT * FROM Bank_Account where Account_Number=:acc");
$stmt1->execute(array(
	":acc" => $account
));
$result = $stmt1->fetchAll();
$e = $stmt1->errorInfo();
if($e[0] != "00000"){
	var_dump($e);
	echo "setting eee ".$e."<br>";
}
$type=$result[0]["Account_Type"];
$amount=$result[0]["Balance"];

echo "<h3>Details of ".$account."</h3><br>";
echo "<h4>Account Type: ".$type."</h4><br>";
echo "<h4>Balance : ".$amount."</h4><br>";
?>
