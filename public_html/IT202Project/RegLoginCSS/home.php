<?php
include("header.php");

?>
<h4>Home</h4>
<?php echo "Welcome, " . $_SESSION["user"]["email"];
echo var_export($_SESSION, true);?>
<?php
require("common.inc.php");
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$stmt = $db->prepare("SELECT * FROM Bank_Account");
$stmt->execute();
?>
