<?php
include("header.php");

$email=$_SESSION["user"]["email"];
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
$account=$_GET["Account_Number"];
//var_dump($new_arr);
echo "Hello". $email;?>
<form method="POST">
	<label for="name">From
	</label>
	<input type="text" id="Name" name="Name" value="<?php echo $account; ?>" readonly>
  <label for="to">To
	</label>
	<input type="text" id="Name1" name="Name1"  />
  <label for="to">Last 6 digits
	</label>
	<input type="text" id="Name2" name="Name2"  />
	<label for="balance">Amount
	<input type="number" id="balance" name="Balance" />
	</label>
	<input type="submit" name="Transfer" value="Transfer"/>
</form>
<?php
require("common.inc.php");
require("config.php");
if(isset($_POST["Transfer"])){
  $name = $_POST["Name"];
  $name1a = $_POST["Name1"];
  
  $name2 = $_POST["Name2"];
	
	$balance = $_POST["Balance"];
	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	$db = new PDO($connection_string, $dbuser, $dbpass);
  $stmt1 = $db->prepare("SELECT Account_Number FROM Bank_Accounts where Status='Active' and Name=:acc and Account_Number like :acc1");
	$stmt1->execute(array(
		":acc" => $name1a,
    ":acc1" => "%".$name2
	));
	$result = $stmt1->fetchAll();
	$name1=$result[0]["Account_Number"];
  
	$stmt1 = $db->prepare("SELECT * FROM Bank_Accounts where Account_Number=:acc");
	$stmt1->execute(array(
		":acc" => $name
	));
	$result = $stmt1->fetchAll();
	$amount=$result[0]["Balance"];
	$amount=$amount-$balance;
	$stmt1->execute(array(
		":acc" => $name1
	));
	$result = $stmt1->fetchAll();
	$amount1=$result[0]["Balance"];
	$amount1=$amount1+$balance;
	
    if(!empty($name) && !empty($balance) && !empty($name1) && $balance>0 &&  $amount>5){
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
		$balance=$balance * -1;		
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => $name,
		    ":accnum1" => $name1,
		    ":typ" => "Transfer",
		    ":balance" => $balance,
		    ":exp_balance" => $amount
            ));
		$e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    var_dump($e);
		    echo "setting eee ".$e."<br>";
            }
		$balance =$balance * -1;
		$stmt2 = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:acc1,:acc, :typ,:balance,:exp_balance)");
            $result1 = $stmt2->execute(array(
		    ":acc1" => $name1,
		    ":acc" => $name,
		    ":typ" => "Transfer",
		    ":balance" => $balance,
		    ":exp_balance" => $amount1
            ));
		$e = $stmt2->errorInfo();
            if($e[0] != "00000"){
		    var_dump($e);
		    $stmt2->debugDumpParams();
		    echo "setting AAAAAeee ".$e."<br>";
            }
		$stmt = $db->prepare("update Bank_Accounts set Balance= (SELECT sum(Amount) FROM Transactions WHERE Acc_Src=:accnum) where Account_Number=:accnum");
            $result = $stmt->execute(array(
                ":accnum" => $name
            ));
            $res = $stmt->execute(array(
                ":accnum" => $name1
            ));
                if ($result){
                    echo "Successfully transferred ".$balance." from account " . $name." to account ".$name1;
			//header("Location: home.php");
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
        echo "Account and Amount must not be empty. Amount has to be greater than zero. As a result of transfer accounts should maintain 5 Dollar balance.";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Accounts");
$stmt->execute();
?>
