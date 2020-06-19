<?php
require("common.inc.php");
$db = getDB();
$Accnum1 = $_POST["Account_Number"];
//example usage, change/move as needed
$stmt = $db->prepare("DELETE from Bank_Account where Account_Number=$Accnum1");
$stmt->execute();
?>