<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$AccNum = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
?>

<form method="POST">
	<label for="email">email
	<input type="text" id="email" name="email" value="<?php echo get($result, "email");?>" />
	</label>
	<label for="First_name">First_name
	<input type="text" id="Fname" name="Fname" value="<?php echo get($result, "Fname");?>" />
	</label>
	<label for="Last_name">Last_name
	<input type="text" id="Lname" name="Lname" value="<?php echo get($result, "Lname");?>" />
	</label>
	<label for="password">Password
	<input type="text" id="password" name="password" value="<?php echo get($result, "password");?>" />
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
	$password = $_POST["password"];
	$hash=password_hash($password, PASSWORD_BCRYPT);
    if(!empty($email) || !empty($Fname) || !empty($Lname) || !empty($passowrd)){
        try{
		echo "in try block";
                $stmt = $db->prepare("UPDATE User set email='$email', First_name='$Fname', Last_name='$Lname', password='$hash' where Id=1");
                $result = $stmt->execute();
				var_dump($stmt);
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
