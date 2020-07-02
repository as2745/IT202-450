<?php
include("header.php");
echo "Hello". $_SESSION["user"]["email"];?>
<form method="POST">
	<label for="name">Account Name
	<input type="text" id="Name" name="Name" />
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
require("common.inc.php");
$db = getDB();
if(isset($_POST["Bank"])){
    $name = $_POST["Name"];
    
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
	$email=$_SESSION["user"]["email"];
	echo $email;
    if(!empty($name) && !empty($Accnum)&& !empty($Acctyp)&& !empty($balance)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
		$stmt1 = $db->prepare("SELECT id FROM Users where email = :email LIMIT 1");
		$res=$stmt1->execute(array(
					":email" => $email
				));
		$user_id=$res["id"];
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Number, Account_Type,Balance,user_id) VALUES (:name, :Accnum, :Acctyp,:balance,:user)");
            $result = $stmt->execute(array(
                ":name" => $name,
				":Acctyp"=> $Acctyp,
				":balance"=> $balance,
		    ":user"=>$user_id
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                //echo var_export($result, true);
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
        echo "<div>Name, Account Number, Account Type and Balance must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>
