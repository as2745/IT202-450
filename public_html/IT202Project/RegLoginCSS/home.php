<?php
include("header.php");
require("common.inc.php");
require("config.php");


$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);

$email=$_GET["email"];

if(empty($email)){
  $accounts=$_SESSION["user"]["accounts"];
}
else{
  $query=$db->prepare("SELECT b.Account_Number FROM Bank_Accounts b, User a where a.id=b.User_id and a.email=:email");
  $query->execute(array(
    ":email" => $email
  ));
  $res = $query->fetchAll();$accounts=$res;
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
