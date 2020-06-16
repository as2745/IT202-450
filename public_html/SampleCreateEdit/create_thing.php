<form method="POST">
	<label for="name">Account Name
	<input type="text" id="Name" name="Name" />
	</label>
	<label for="accnumber">Account Number
	<input type="number" id="AccNum" name="Account_Number" />
	</label>
	<input type="submit" name="Bank" value="Create Account"/>
</form>

<?php
if(isset($_POST["created"])){
    $name = $_POST["Name"];
    $Accnum = $_POST["Account_Number"];
    if(!empty($name) && !empty($Accnum)){
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try{
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Bank_Account (Name, Account_Number) VALUES ($name, $Accnum)");
            $result = $stmt->execute(array(
                ":Name" => $name,
                ":Account_Number" => $Accnum
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
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
        echo "Name and Account_Number must not be empty.";
    }
}
?>