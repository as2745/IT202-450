<form method="POST">
	
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	
	<input type="submit" name="Bank" value="Delete Account"/>
</form>
<?php
require("common.inc.php");
$db = getDB();
$Accnum1 = $_POST["Account_Number"];
//example usage, change/move as needed
$stmt = $db->prepare("DELETE from Bank_Account where Account_Number=$Accnum1");
                    $result = $stmt->execute(array(
                        ":id" => $Accnum1
                    ));
?>
