<?php
include("header.php");
require("common.inc.php");
require("config.php");
$accounts=$_SESSION["user"]["accounts"];
echo "after accounts";
$new_arr = array_column($accounts,'Account_Number');
echo "after new_arr";
//<h4>Home</h4>
//echo "Welcome, " . $_SESSION["user"]["email"];
//echo var_export($_SESSION, true);

        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$stmt = $db->prepare("SELECT Account_Number FROM Bank_Account");
echo "after query";
$stmt->execute();
echo "after execution";
        foreach($new_arr as $item){
        var_dump($item);
        }
?>
