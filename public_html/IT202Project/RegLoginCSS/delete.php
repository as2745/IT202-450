<form method="POST">
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	<input type="submit" name="Bank" value="Deactivate Account"/>
</form>
<?php
require("common.inc.php");
$db = getDB();
$Accnum1 = $_POST["Account_Number"];
//example usage, change/move as needed
$stmt = $db->prepare("UPDATE Bank_Accounts SET Status = Inactive WHERE Account_Number=$Accnum1");
                    $result = $stmt->execute(array(
                        ":id" => $Accnum1
                    ));
?>
