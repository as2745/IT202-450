<?php
include("header.php");

$email=$_SESSION["user"]["email"];
echo "Hello". $email;?>
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
echo "before major if 1";
require("common.inc.php");

echo "before major if 2";
if(isset($_POST["Bank"])){
echo "before major if 2a";
    $name = $_POST["Name"];
    
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
	echo "before major if 3";
    if(!empty($name) && !empty($Acctyp)&& !empty($balance)){
	    echo "before major if 3a<br>";
        require("config.php");
	    echo "before major if 3b<br>";
	    echo "before major if 3c<br>";
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	    echo "Inside major if";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
		try{
		$stmt1 = $db->prepare("SELECT id FROM Users where email = :email LIMIT 1");
		$res=$stmt1->execute(array(
					":email" => $email
				));
		$user_id=$res["id"];
		}catch (Exception $e1){
            echo $e1->getMessage();
			$user_id=15;
        }
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Type, Balance, User_id) VALUES (:name, :Acctyp,:balance,:user)");
            $result = $stmt->execute(array(
                ":name" => $name,
				":Acctyp"=> $Acctyp,
				":balance"=> $balance,
		    ":user"=>$User_id
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
	    echo "did not go through if";
        echo "<div>Name, Account Type and Balance must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>
