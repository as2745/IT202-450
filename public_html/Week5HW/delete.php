<form method="POST">
	<label for="name">Account Name
	<input type="text" id="Name" name="Name" />
	</label>
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	<label for="acctype">Account Type
	<input type="text" id="AccTyp" name="Account_Type" />
	</label>
	<label for="balance">Balance
	<input type="number" id="balance" name="Balance" />
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