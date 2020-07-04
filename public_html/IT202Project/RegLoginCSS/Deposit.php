<?php
include("header.php");
//SELECT b.Account_Number FROM `Bank_Account` b, `Users` a where a.id=b.User_id and a.email='a@a.com'
require("common.inc.php");
require("config.php");
$connection_str = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db1 = new PDO($connection_string, $dbuser, $dbpass);
$query=$db1->prepare("SELECT b.Account_Number FROM Bank_Account b, Users a where a.id=b.User_id and a.email=:email");
$email=$_SESSION["user"]["email"];
$result = $query->execute(array(
		    ":email" => $email
            ));
$res = $query->fetchAll();
print_r($res);
echo "Hello". $email;?>
<form method="POST">
	<label for="name">Account
	<input type="text" id="Name" name="Name" />
	</label>
	
	<label for="balance">Amount
	<input type="number" id="balance" name="Balance" />
	</label>
	<input type="submit" name="Deposit" value="Deposit"/>
</form>
<?php
//echo "before major if 1";
require("common.inc.php");

//echo "before major if 2";
if(isset($_POST["Deposit"])){
//echo "before major if 2a";
    $name = $_POST["Name"];
    
	
	$balance = $_POST["Balance"];
	//echo "before major if 3";
    if(!empty($name) && !empty($balance)){
	   // echo "before major if 3a<br>";
        require("config.php");
	  //  echo "before major if 3b<br>";
	    
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	  //  echo "Inside major if";
        try{
		//echo "before major if 3c<br>";
            $db = new PDO($connection_string, $dbuser, $dbpass);
		//echo "before major if 3d<br>";
		
		$stmt = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:accnum,:accnum1, :typ,:balance,:exp_balance)");
            $result = $stmt->execute(array(
		    ":accnum" => $name,
		    ":accnum1" => "000000000000",
		    ":typ" => "Deposit",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    var_dump($e);
		    echo "setting eee ".$e."<br>";
                //echo var_export($e, true);
            }
		$balance =$balance * -1;
		echo $balance;
		
		$stmt2 = $db->prepare("INSERT INTO Transactions (Acc_Src, Acc_Dst,Type,Amount,Expected_total) VALUES (:acc1,:acc, :typ,:balance,:exp_balance)");
            $result1 = $stmt2->execute(array(
		    ":acc1" => "000000000000",
		    ":acc" => $name,
		    ":typ" => "WithDraw",
		    ":balance" => $balance,
		    ":exp_balance" => $balance
            ));
		$e = $stmt2->errorInfo();
            if($e[0] != "00000"){
		    var_dump($e);
		    $stmt2->debugDumpParams();
		    echo "setting AAAAAeee ".$e."<br>";
                //echo var_export($e, true);
            }
		$stmt = $db->prepare("update Bank_Account set Balance= (SELECT sum(Amount) FROM Transactions WHERE Acc_Src=:accnum) where Account_Number=:accnum");
            $result = $stmt->execute(array(
                ":accnum" => $name
            ));
            //$e = $stmt->errorInfo();
            //if($e[0] != "00000"){
		  //  echo "setting eee <br>";
                //echo var_export($e, true);
           // }
		//echo $acc_id;
            //else{
                //echo var_export($result, true);
                if ($result){
		//if($res){
                    echo "Successfully inserted new thing: " . $name;
                }
                else{
                    echo "Error inserting record";
                }
            }
        //}
        catch (Exception $e){
		echo "Error inserting record 1";
            echo $e->getMessage();
        }
    }
	
    else{
	   // echo "did not go through if";
        echo "<div>Account and Amount must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>