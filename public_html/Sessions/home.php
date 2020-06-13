<h1>Welcome to the Home page</h1>
<?php
session_start();
echo "Welcome, " . $_SESSION["user"]["email"];
?>
<a href="logout.php">Logout</a>