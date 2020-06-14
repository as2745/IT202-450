<h1>Welcome to the Home page</h1>
<?php
include("header.php");

?>
<h4>Home</h4>
<?php echo "Welcome, " . $_SESSION["user"]["email"];?>