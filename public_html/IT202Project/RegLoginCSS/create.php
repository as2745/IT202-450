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
require("common.inc.php");
if(isset($_POST["Bank"])){
    $name = $_POST["Name"];
    
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
    if(!empty($name) && !empty($Acctyp)&& !empty($balance)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
		try{
		$stmt1 = $db->prepare("SELECT id FROM Users where email = :email LIMIT 1");
		$stmt1->execute(array(
					":email" => $email
				));
			$res = $stmt1->fetch(PDO::FETCH_ASSOC);
		$user_id=$res["id"];
		}catch (Exception $e1){
            echo $e1->getMessage();
        }
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Type, User_id) VALUES (:name, :Acctyp,:user)");
            $result = $stmt->execute(array(
                ":name" => $name,
				":Acctyp"=> $Acctyp,
		    ":user"=>$user_id
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
		$stmt1 = $db->prepare("SELECT max(id) as id FROM Bank_Account where Name = :name and Account_Type=:Acctyp and User_id=:user");
		$stmt1->execute(array(
					":name" => $name,
				":Acctyp"=> $Acctyp,
		    ":user"=>$user_id
				));
			$res = $stmt1->fetch(PDO::FETCH_ASSOC);
		$acc_id=$res["id"];
		$account_num=str_pad($acc_id, 12, "0", STR_PAD_LEFT);
		//echo $acc_id;
		//echo " ".$account_num."<br>";
		$stmt = $db->prepare("update Bank_Account set Account_number=:accnum where id=:idnum");
            $result = $stmt->execute(array(
                ":accnum" => $account_num,
		    ":idnum"=>$acc_id
            ));
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => "000000000000",
		    ":accnum1" => $account_num ,
		    ":typ" => "Deposit",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    var_dump($e);
		    echo "setting eee ".$e."<br>";
            }
		$balance =$balance * -1;
		//echo $balance;
		
		$stmt2 = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:acc1,:acc, :typ,:balance,:exp_balance)");
            $result1 = $stmt2->execute(array(
		    ":acc1" => $account_num,
		    ":acc" => "000000000000",
		    ":typ" => "WithDraw",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt2->errorInfo();
            if($e[0] != "00000"){
		    //var_dump($e);
		    //$stmt2->debugDumpParams();
		    //echo "setting AAAAAeee ".$e."<br>";
            }
		$stmt = $db->prepare("update Bank_Account set Balance= (SELECT sum(Amount) FROM Transactions WHERE Acc_Dst=:accnum) where Account_Number=:accnum");
            $result = $stmt->execute(array(
                ":accnum" => $account_num
            ));
                if ($result){
                    echo "Successfully Created new Account for : " . $name;
                }
                else{
                    echo "Error inserting record";
                }
            }
        catch (Exception $e){
		
            echo $e->getMessage();
        }
    }
	
    else{
	    
        echo "<div>Name, Account Type and Balance must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>
