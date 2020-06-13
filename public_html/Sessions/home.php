<?php
session_start();
<h1>Welcome to the Home page</h1>
echo "Welcome, " . $_SESSION["user"]["email"];
?>
<a href="logout.php">Logout</a>