<?php
include("header.php");
require("common.inc.php");
require("config.php");


$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

$email=$_GET["email"];
$pwdreset=$_GET["resetpassword"];
if(!empty($pwdreset)){
}
if(empty($email)){
  $accounts=$_SESSION["user"]["accounts"];
}
else{
  $stmt = $db->prepare("SELECT First_name, Last_name, Id from User where email='$email'");
  $stmt->execute();
  $result = $stmt->fetchAll();
  $fname=$result[0]["First_name"];
  $lname=$result[0]["Last_name"];
  $id=$result[0]["Id"];
}

$new_arr = array_column($accounts,'Account_Number');
echo "<a href=create.php>Create a new account</a>"; 
echo "<br>";
        foreach($new_arr as $item){
                echo "<a href=AcctDetails.php?account=". $item.">".$item."</a>"; 
                 echo "<a href=Deposit.php?Account_Number=". $item.">Deposit</a>"; 
                 echo "<a href=Withdraw.php?Account_Number=".$item.">Withdraw</a>";
                 echo "<a href=Transfer.php?Account_Number=".$item.">Transfer</a>";
                echo '<br>';
        }
?>
