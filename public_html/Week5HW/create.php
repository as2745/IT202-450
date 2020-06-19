<?php
require("common.inc.php");
$db = getDB();


if(isset($_POST["Bank"])){
    $name = $_POST["Name"];
    $Accnum = $_POST["Account_Number"];
	$Acctyp = $_POST["Account_Type"];
	$balance = $_POST["Balance"];
    if(!empty($name) && !empty($Accnum)&& !empty($Acctyp)&& !empty($balance)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Number, Account_Type,Balance) VALUES (:name, :Accnum, :Acctyp,:balance)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":Accnum" => $Accnum,
				":Acctyp"=> $Acctyp,
				":balance"=> $balance
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                //echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted new thing: " . $name;
                }
                else{
                    echo "Error inserting record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "<div>Name, Account Number, Account Type and Balance must not be empty.<div>";
    }
}
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>