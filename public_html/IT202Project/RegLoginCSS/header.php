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
            <a href="home.php">Home</a> \t <a href="login.php">Login</a> \t <a href="register.php">Register</a> \t <a href="logout.php">Logout</a>
        </li>
    </ul>
</nav>
