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
	<label for="name">Account_Name
	<input type="text" id="Name" name="Name" value="<?php echo get($result, "Name");?>" />
	</label>
	<label for="accnumber">Account_Number
	<input type="number" id="AccNum" name="Account_Number" value="<?php echo get($result, "Account_Number");?>" />
	</label>
	<label for="acctype">Account_Type
	<input type="text" id="AccType" name="Account_Type" value="<?php echo get($result, "Account_Type");?>" />
	</label>
		<label for="balance">Balance
	<input type="number" id="balance" name="Balance" value="<?php echo get($result, "Balance");?>" />
	</label>
	    <input type="submit" name="updated" value="Update Thing"/>
</form>
<?php
if(isset($_POST["updated"]) || isset($_POST["created"])){
    $name = $_POST["Name"];
    $Accnum1 = $_POST["Account_Number"];
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
    if(!empty($name) && !empty($Accnum1)&& !empty($Acctyp)&& !empty($balance)){
        try{
                $stmt = $db->prepare("UPDATE Bank_Account set Name='$name', Account_Type='$Acctyp', Balance=$balance where Account_Number=$Accnum1");
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