<?php
require("config.php");
include("header.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$AccNum = -1;
$result = array();
$email=$_GET["email"];
$pwdreset=$_GET["resetpassword"];
if(!empty($pwdreset)){
}
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
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
?>
<form method="POST">
	<label for="email">email
	<input type="text" id="email" name="email" value="<?php echo $email;?>" />
	</label>
	<label for="First_name">First_name
	<input type="text" id="Fname" name="Fname" value="<?php echo $fname;?>" />
	</label>
	<label for="Last_name">Last_name
	<input type="text" id="Lname" name="Lname" value="<?php echo $lname;?>" />
	</label>
	<label for="password" <?php if(empty($pwdreset)) echo 'style="visibility:hidden;"'?>>Password
	<input type="text" id="password" name="password" <?php if(empty($pwdreset)) echo 'style="visibility:hidden;"'?> value="<?php echo get($result, "password");?>" />
	</label><br>
	    <input type="submit" name="updated" value="Update"/>
</form>
<?php
//echo "before update/create check";
if(isset($_POST["updated"]) || isset($_POST["created"])){
	//echo "after create/update check";
	$mail = $_POST["email"];
	$Fname = $_POST["Fname"];
	$Lname = $_POST["Lname"];
	$pssword = $_POST["password"];
	
	$hash=password_hash($pssword, PASSWORD_BCRYPT);
	
    if(!empty($email) || !empty($Fname) || !empty($Lname) || !empty($pssowrd)){
        try{
		$stmt = $db->prepare("SELECT count(*) as num from User where email='$email'");
                //$stmt = $db->prepare("UPDATE User set email='$email', First_name='$Fname', Last_name='$Lname', password='$hash' where Id=1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		$num=$result[0]["num"];
		if($num>0 && $mail!=$email){
			$error = 'Email Already in use';
			throw new Exception($error);
		}
		
		if($num==0 && $mail!=$email){
			$str="UPDATE User set email='$mail', First_name='$Fname', Last_name='$Lname'";
		}
		else $str="UPDATE User set First_name='$Fname', Last_name='$Lname'";
		if(!empty($pssword) && !empty($pwdreset) ){
			$str=$str.", password='$hash'";
		}
			$str=$str." where Id=$id";			
			$stmt = $db->prepare($str);
			$stmt->execute();
		

            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    echo "try 1 if";
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
			if(empty($_GET["email"])){
			$_SESSION["user"]["email"]=$email;
 function get($arr, $key){
        }
    }
    else{
	    var_dump($email);
	    var_dump($Fname);
	    var_dump($Lname);
	    var_dump($password);
        echo "Name and quantity must not be empty.";
        echo "Email, First name or Last name must not be empty.";
    }
}
?>
