<form method="POST">
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	<input type="submit" name="Bank" value="Deactivate Account"/>
</form>
<?php
include("header.php");
require("common.inc.php");
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$Accnum1 = $_POST["Account_Number"];
var_dump($Accnum1);
//example usage, change/move as needed
$stmt = $db->prepare("UPDATE Bank_Accounts SET Status = Inactive WHERE Account_Number='$Accnum1'");
                    $result = $stmt->execute();
?>
