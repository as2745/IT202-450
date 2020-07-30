<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
echo "<a href=create.php>Create a new account</a>"; 
        foreach($new_arr as $item){
                echo "<a href=AcctDetails.php?account=". $item.">".$item."</a>"; 
                 echo "<a href=Deposit.php?Account_Number=". $item.">Deposit</a>"; 
                 echo "<a href=Withdraw.php?Account_Number=".$item.">Withdraw</a>";
                 echo "<a href=Transfer.php?Account_Number=".$item.">Transfer</a>";
                echo '<br>';
        }
?>
