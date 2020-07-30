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
}
else{
  echo "User ".$email." Not authorized on this page.";
}

?>
<h3>Profile Details</h3>
<h4>Email: <?php echo $email;?><h4><br>
<h4>First Name: <?php echo $fname;?><h4><br>
<h4>Last Name: <?php echo $lname;?><h4><br>
<a href="viewprofile.php?email=<?php echo $email;?>">Edit Profile</a><br>
<a href="viewprofile.php?resetpassword=yes&email=<?php echo $email;?>">Reset Password</a><br>
