<head>
<style>
li {
  list-style-type: none;
  margin: 10px;
  padding: 0;
}
</style>
    <title>My site</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
require("config.php");
session_start();
?>
<nav>
    <ul>
        <li>
            <a href="home.php">Home</a></li>  <li><a href="login.php">Login</a></li>  <li><a href="register.php">Register</a></li>  <li><a href="logout.php">Logout</a></li>
        </li>
    </ul>
</nav>
