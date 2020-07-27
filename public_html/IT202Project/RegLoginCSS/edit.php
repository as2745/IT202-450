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
	<label for="accnumber">First_name
	<input type="text" id="Fname" name="First_name" value="<?php echo get($result, "First_name");?>" />
	</label>
	<label for="acctype">Last_name
	<input type="text" id="Lname" name="Last_name" value="<?php echo get($result, "Last_name");?>" />
	</label>
	<label for="balance">Password
	<input type="text" id="password" name="password" value="<?php echo get($result, "password");?>" />
	</label>
	    <input type="submit" name="updated" value="Update Thing"/>
</form>
<?php
if(isset($_POST["updated"]) || isset($_POST["created"])){
    $email = $_POST["email"];
    $Fname = $_POST["First_name"];
	$Lname = $_POST["Last_name"];
	$password = $_POST["password"];
    if(!empty($name) && !empty($Accnum1)&& !empty($Acctyp)&& !empty($balance)){
        try{
                $stmt = $db->prepare("UPDATE Bank_Accounts set Name='$name', Account_Type='$Acctyp', Balance=$balance where Account_Number=$Accnum1");
                $result = $stmt->execute();
				var_dump($stmt);
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted or updated thing: " . $name;
                }
                else{
                    echo "Error inserting or updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name and quantity must not be empty.";
    }
}
?>
