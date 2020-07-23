<form method="POST">
	
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	
	<input type="submit" name="Bank" value="Delete Account"/>
</form>
<?php
require("common.inc.php");
$db = getDB();
//example usage, change/move as needed
$stmt = $db->prepare("UPDATE Bank_Accounts SET Status=Inactive WHERE Id=1");
			$result = $stmt->execute
			var_dump($result);
?>
