<head>

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
            <a href="home.php">Home</a>  <a href="login.php">Login</a>  <a href="register.php">Register</a>  <a href="logout.php">Logout</a> <a href="edit.php">Maintain Accounts</a>
        </li>
    </ul>
</nav>
