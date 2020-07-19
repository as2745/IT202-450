<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
        foreach($new_arr as $item){
                echo $item;
                 echo '<a href="Deposit.php?Account_Number=<?php echo $item;?>">Deposit</a>'; 
                 echo '<a href="Withdraw.php?Account_Number=<?php echo $item;?>">Withdraw</a>';
                 echo '<a href="Transfer.php?Account_Number=<?php echo $item;?>">Transfer</a>';
                echo '<br>';
        }
?>
