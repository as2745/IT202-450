<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
echo "after accounts";
$new_arr = array_column($accounts,'Account_Number');
        foreach($new_arr as $item){
        var_dump($item);
        }
?>
