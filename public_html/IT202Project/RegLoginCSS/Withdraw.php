
<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
$account=$_GET["Account_Number"];
echo "Hello". $email;?>
<form method="POST">
	<label for="name">Account
		<input type="text" id="Name" name="Name" value="<?php echo $account; ?>" readonly>
	</label>
	
	<label for="balance">Amount
	<input type="number" id="balance" name="Balance" />
	</label>
	<input type="submit" name="Withdraw" value="Withdraw"/>
</form>
<?php
require("common.inc.php");
if(isset($_POST["Withdraw"])){
    $name = $_POST["Name"];
	$balance = $_POST["Balance"];
	$balance=$balance * -1;
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
    if(!empty($name) && !empty($balance) && $amount>=0){
        
        try{
            
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Transaction_Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => $name,
		    ":accnum1" => "000000000000",
		    ":typ" => "WithDraw",
		    ":balance" => $balance,
		    ":exp_balance" => $amount
            ));
		$e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    echo var_export($e, true);
            }
		$balance =$balance * -1;
		echo $balance;
		$stmt2 = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Transaction_Type,Amount,Expected_total) VALUES (:acc1,:acc, :typ,:balance,:exp_balance)");
            $result1 = $stmt2->execute(array(
		    ":acc1" => "000000000000",
		    ":acc" => $name,
		    ":typ" => "WithDraw",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
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
                    echo "Successfully Withdrew from: " . $name;
			header("Location: home.php");
			
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
        echo "<div>Account and Amount must not be empty. Also can't withdraw more than what you have.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Accounts");
$stmt->execute();
?>
