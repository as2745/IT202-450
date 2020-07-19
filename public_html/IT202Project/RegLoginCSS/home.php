<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
        foreach($new_arr as $item){
                echo $item;
                 <a href="Deposit.php">Deposit</a> 
                 <a href="Withdraw.php">Withdraw</a> 
                 <a href="Transfer.php">Transfer</a>
                echo '<br>';
        }
?>
