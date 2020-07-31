<?php
require("config.php");
include("header.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$AccNum = -1;
$result = array();
$email=$_GET["email"];
if(empty($email))
  $email=$_SESSION["user"]["email"];
$stmt = $db->prepare("SELECT First_name, Last_name, Id, role from User where email='$email'");
$stmt->execute();
$result = $stmt->fetchAll();
$role=$result[0]["role"];
if($role=='Admin'){
  $stmt = $db->prepare("SELECT email from User where role='User'");
  $stmt->execute();
  $result = $stmt->fetchAll();
  $new_arr = array_column($result,'email');
}
else{
  echo "User ".$email." Not authorized on this page.";
}

foreach($new_arr as $item){
                echo $item."<a href=edit.php?email=". $item.">Edit</a>"."<a href=home.php?email=". $item.">Accounts</a>"; 
                echo '<br>';
        }

?>
