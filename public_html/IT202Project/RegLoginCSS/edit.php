<?php
require("config.php");
include("header.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$AccNum = -1;
$result = array();
$email=$_SESSION["user"]["email"];
$fname=$_SESSION["user"]["first_name"];
$lname=$_SESSION["user"]["last_name"];
$id=$_SESSION["user"]["id"];
var_dump($id);
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
	<label for="password">Password
	<input type="text" id="password" name="password" />
	</label>
	    <input type="submit" name="updated" value="Update Thing"/>
</form>
<?php
//echo "before update/create check";
if(isset($_POST["updated"]) || isset($_POST["created"])){
	//echo "after create/update check";
	$email = $_POST["email"];
	$Fname = $_POST["Fname"];
	$Lname = $_POST["Lname"];
	$pssword = $_POST["password"];
	$hash=password_hash($password, PASSWORD_BCRYPT);
	
    if(!empty($email) || !empty($Fname) || !empty($Lname) || !empty($pssowrd)){
        try{
		echo "in try block";
		$stmt = $db->prepare("SELECT count(*) as num from User where email='$email'");
                //$stmt = $db->prepare("UPDATE User set email='$email', First_name='$Fname', Last_name='$Lname', password='$hash' where Id=1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		$num=$result[0]["num"];
		var_dump($num);
               // $result = $stmt->execute();
		if($num==0){
			$str="UPDATE User set email='$email', First_name='$Fname', Last_name='$Lname'";
			var_dump($pssowrd);
			var_dump(empty($pssowrd));
			echo '<br>';
			var_dump($hash);
			echo '<br>';
			if(!empty($pssowrd)){
				$str=$str.", password='$hash'";
				var_dump($email);
				echo '<br>';
				var_dump($str);
				echo '<br>';
				var_dump($hash);
				echo '<br>';
			}
			$str=$str." where Id=$id";
			//$stmt->execute();
			$stmt = $db->prepare($str);
			var_dump($str);
		}
		else{
                    echo "Email already in use";
                }
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
		    echo "try 1 if";
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
			echo "try 2 if";
                    echo "Successfully inserted or updated thing: " . $email;
                }
                else{
                    echo "Error inserting or updating record";
                }
            }
        }
        catch (Exception $e){
		echo "in catch block";
		echo $e->getMessage();
        }
    }
    else{
	    var_dump($email);
	    var_dump($Fname);
	    var_dump($Lname);
	    var_dump($password);
        echo "Name and quantity must not be empty.";
    }
}
?>
