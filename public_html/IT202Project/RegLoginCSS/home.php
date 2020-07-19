<?php
include("header.php");
$accounts=$_SESSION["user"]["accounts"];
$new_arr = array_column($accounts,'Account_Number');
?>
<h4>Home</h4>
<?php 
echo "Welcome, " . $_SESSION["user"]["email"];
echo var_export($_SESSION, true);
?>
<?php
require("common.inc.php");
require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$stmt = $db->prepare("SELECT Account_Number FROM Bank_Account");
$stmt->execute();
        foreach($new_arr as $item){
        echo $item;
        }
?>
