<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
        foreach($new_arr as $item){
                echo $item;
                 echo '<a href="Deposit.php?Account_Number=000000000023">Deposit</a>'; 
                 echo '<a href="Withdraw.php">Withdraw</a>';
                 echo '<a href="Transfer.php">Transfer</a>';
                echo '<br>';
        }
?>
