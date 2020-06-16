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
	<input type="submit" name="Bank" value="Create Account"/>
</form>

<?php
if(isset($_POST["created"])){
    $name = $_POST["Name"];
    $Accnum = $_POST["Account_Number"];
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
    if(!empty($name) && !empty($Accnum)&& !empty($Acctyp)&& !empty($balance)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Number, Account_Type,Balance) VALUES ($name, $Accnum, $Acctyp,$balance)");
            $result = $stmt->execute(array(
                ":Name" => $name,
                ":Account_Number" => $Accnum
				":Account_Type"=> $Acctyp
				":Balance"=> $balance
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted new thing: " . $name;
                }
                else{
                    echo "Error inserting record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name, Account Number, Account Type and Balance must not be empty.";
    }
}
?>