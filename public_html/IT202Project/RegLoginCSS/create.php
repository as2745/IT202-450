<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
echo "Hello". $email;?>
<form method="POST">
	<label for="name">Account Name
	<input type="text" id="Name" name="Name" />
	</label>
	<label for="acctype">Account Type
		<select id="AccTyp" name="Account_Type" >
			<option value="Checkings">Checkings</option>
			<option value="Savings">Savings</option>
		</select>
	</label>
	<label for="balance">Balance
	<input type="number" id="balance" name="Balance" />
	</label>
	<label for="transfer">Transfer from
	
	<select name="Transfer" id="Transfer">
		<option value=""></option>
		<?php
        foreach($new_arr as $item){
        ?>
        <option value="<?php echo strtolower($item); ?>"><?php echo $item; ?></option>
        <?php
        }
        ?>
	</select></label>
	<input type="submit" name="Bank" value="Create Account"/>
</form>
<?php
require("common.inc.php");
if(isset($_POST["Bank"])){
    $name = $_POST["Name"];
    
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
	$transfer = $_POST["Transfer"];
	$type = "Deposit";
	require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	$db = new PDO($connection_string, $dbuser, $dbpass);
	$amount=0.0;
	if(empty($transfer))
		$transfer= '000000000000';
	else {
		$type = "Transfer";
		$stmt1 = $db->prepare("SELECT * FROM Bank_Accounts where Account_Number=:acc");
		$stmt1->execute(array(
			":acc" => $transfer
		));
		$result = $stmt1->fetchAll();
		$amount=$result[0]["Balance"];
	
		
	     }
	$amount=$amount-$balance;
    if(!empty($name) && !empty($Acctyp)&& !empty($balance) && $balance>=5){
        
        try{
            
		try{
		$stmt1 = $db->prepare("SELECT id FROM User where email = :email LIMIT 1");
		$stmt1->execute(array(
					":email" => $email
				));
			$res = $stmt1->fetch(PDO::FETCH_ASSOC);
		$user_id=$res["id"];
		}catch (Exception $e1){
            echo $e1->getMessage();
        }
		if($Acctyp == 'Savings')
			$APY=3.25;
		else $APY=0.00;
            $stmt = $db->prepare("INSERT INTO Bank_Accounts (Name, Account_Type, User_id, APY) VALUES (:name, :Acctyp,:user,:APY)");
            $result = $stmt->execute(array(
                ":name" => $name,
				":Acctyp"=> $Acctyp,
		    ":user"=>$user_id,
		    ":APY"=> $APY
            ));
		
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
		$stmt1 = $db->prepare("SELECT max(id) as id FROM Bank_Accounts where Name = :name and Account_Type=:Acctyp and User_id=:user");
		$stmt1->execute(array(
					":name" => $name,
				":Acctyp"=> $Acctyp,
		    ":user"=>$user_id
				));
			$res = $stmt1->fetch(PDO::FETCH_ASSOC);
		$acc_id=$res["id"];
		$account_num=str_pad($acc_id, 12, "0", STR_PAD_LEFT);
		echo $acc_id;
		echo " ".$account_num."<br>";
		$stmt = $db->prepare("update Bank_Accounts set Account_number=:accnum where id=:idnum");
            $result = $stmt->execute(array(
                ":accnum" => $account_num,
		    ":idnum"=>$acc_id
            ));
		$balance =$balance * -1;
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => $transfer,
		    ":accnum1" => $account_num ,
		    ":typ" => $type,
		    ":balance" => $balance,
		    ":exp_balance" => $amount
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
		    ":acc" => $transfer,
		    ":typ" => $type,
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt2->errorInfo();
            if($e[0] != "00000"){
		    //var_dump($e);
		    //$stmt2->debugDumpParams();
		    //echo "setting AAAAAeee ".$e."<br>";
            }
		$stmt = $db->prepare("update Bank_Accounts set Balance= (SELECT sum(Amount) FROM Transactions WHERE Acc_Src=:accnum) where Account_Number=:accnum");
            $result = $stmt->execute(array(
                ":accnum" => $account_num
            ));
                if ($result){
                    echo "Successfully Created new Account for : " . $name;
			$query=$db->prepare("SELECT b.Account_Number FROM Bank_Accounts b, Users a where a.id=b.User_id and a.email=:email");
			$query->execute(array(
				":email" => $email
			));
			$res = $query->fetchAll();
			$_SESSION["user"]["accounts"]=$res;
			echo var_export($_SESSION, true);
			//header("Location: home.php");
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
	    
        echo "<div>Name, Account Type and Balance must not be empty. Also Balance must be atleast 5 Dollars.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Accounts");
$stmt->execute();
?>
