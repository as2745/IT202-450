<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$account=$_GET["Account_Number"];
$new_arr = array_column($accounts,'Account_Number');
echo "Hello". $email;?>
<form method="POST">
	<label for="name">Account
	</label>
	<input type="text" id="Name" name="Name" value="<?php echo $account; ?>" readonly>
	
	<label for="balance">Amount
	<input type="number" id="balance" name="Balance" />
	</label>
	<input type="submit" name="Deposit" value="Deposit"/>
</form>
<?php
require("common.inc.php");
if(isset($_POST["Deposit"])){
    $name = $_POST["Name"];
	$balance = $_POST["Balance"];
	require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	$db = new PDO($connection_string, $dbuser, $dbpass);
	$stmt1 = $db->prepare("SELECT * FROM Bank_Accounts where Account_Number=:acc");
	$stmt1->execute(array(
		":acc" => $name
	));
	$result = $stmt1->fetchAll();
	$amount=$result[0]["Balance"];
	$amount=$amount+$balance;
    if(!empty($name) && !empty($balance)){
        
        try{
            
		$balance =$balance * -1;
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Transaction_Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => "000000000000",
		    ":accnum1" => $name,
		    ":typ" => "Deposit",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    echo var_export($e, true);
            }
		$balance =$balance * -1;
		echo $balance;
		$stmt2 = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Transaction_Type,Amount,Expected_total) VALUES (:acc1,:acc, :typ,:balance,:exp_balance)");
            $result1 = $stmt2->execute(array(
		    ":acc1" => $name,
		    ":acc" => "000000000000",
		    ":typ" => "Deposit",
		    ":balance" => $balance,
		    ":exp_balance" => $amount
            ));
		$e = $stmt2->errorInfo();
            if($e[0] != "00000"){
		    echo var_export($e, true);
            }
		$stmt = $db->prepare("update Bank_Accounts set Balance= (SELECT sum(Amount) FROM Transactions WHERE Acc_Src=:accnum) where Account_Number=:accnum");
            $result = $stmt->execute(array(
                ":accnum" => $name
            ));
                if ($result){
                    echo "Successfully deposited into: " . $name;
			header("Location: home.php");
                }
                else{
                    echo "Error inserting record";
                }
            }
        catch (Exception $e){
		echo "Error inserting record 1";
            echo $e->getMessage();
        }
    }
    else{
       echo "<div>Account and Amount must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Accounts");
$stmt->execute();
?>
