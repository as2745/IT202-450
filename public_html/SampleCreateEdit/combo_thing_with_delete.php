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
if(isset($_GET["AccNum"])){
    $AccNum = $_GET["AccNum"];
    $stmt = $db->prepare("SELECT * FROM Bank_Account where Account_Number = :AccNum");
    $stmt->execute([":AccNum"=>$AccNum]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        $AccNum = -1;
    }
}
else{
    echo "No AccNum provided in url, don't forget this or sample won't work.";
}
?>

<form method="POST">
	<label for="name">Account Name
	<input type="text" id="Name" name="Name" value="<?php echo get($result, "Name");?>" />
	</label>
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" value="<?php echo get($result, "Account_Number");?>" />
	</label>
	<label for="acctype">Account Type
	<input type="text" id="AccType" name="Account_Type" value="<?php echo get($result, "Account_Type");?>" />
	</label>
		<label for="balance">Balance
	<input type="number" id="balance" name="Balance" value="<?php echo get($result, "Balance");?>" />
	</label>
    <?php if($AccNum > 0):?>
	    <input type="submit" name="updated" value="Update Thing"/>
        <input type="submit" name="delete" value="Delete Thing"/>
    <?php elseif ($AccNum < 0):?>
        <input type="submit" name="created" value="Create Thing"/>
    <?php endif;?>
</form>

<?php
if(isset($_POST["updated"]) || isset($_POST["created"]) || isset($_POST["delete"])){
    $delete = isset($_POST["delete"]);
    $name = $_POST["Name"];
    $Accnum1 = $_POST["Account_Number"];
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
    if(!empty($name) && !empty($Accnum1)&& !empty($Acctyp)&& !empty($balance)){
        try{
            if($AccNum > 0) {
                if($delete){
                    $stmt = $db->prepare("DELETE from Bank_Account where Account_Number=$Accnum1");
                    $result = $stmt->execute(array(
                        ":id" => $AccNum
                    ));
                }
                else {
					$stmt = $db->prepare("UPDATE Bank_Account set Name='$name', Account_Type='$Acctyp', Balance=$balance where Account_Number=$Accnum1");
					$result = $stmt->execute();));
                }
            }
            else{
                $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Number, Account_Type,Balance) VALUES (:name, :Accnum, :Acctyp,:balance)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":Accnum" => $Accnum1,
				":Acctyp"=> $Acctyp,
				":balance"=> $balance
                ));
            }
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully interacted with thing: " . $name;
                }
                else{
                    echo "Error interacting record";
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