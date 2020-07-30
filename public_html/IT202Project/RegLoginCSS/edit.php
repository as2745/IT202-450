<?php
require("config.php");
include("header.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$AccNum = -1;
$result = array();
$email=$_GET["email"];
if(empty($email)){
  $email=$_SESSION["user"]["email"];
  $fname=$_SESSION["user"]["first_name"];
  $lname=$_SESSION["user"]["last_name"];
  $id=$_SESSION["user"]["id"];
}
else{
  $stmt = $db->prepare("SELECT First_name, Last_name, Id from User where email='$email'");
  $stmt->execute();
  $result = $stmt->fetchAll();
  $fname=$result[0]["First_name"];
  $lname=$result[0]["Last_name"];
  $id=$result[0]["Id"];
}
?>
<h3>Profile Details</h3>
<h4>EMAIL: <?php echo $email;?><h4><br>
<h4>EMAIL: <?php echo $fname;?><h4><br>
<h4>EMAIL: <?php echo $lname;?><h4><br>
<a href="viewprofile.php?email=<?php echo $email;?>">Edit Profile</a><br>

<a href="viewprofile.php?resetpassword=yes&email=<?php echo $email;?>">Reset Password</a><br>



