<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html>

<head>
    <title> First task </title>
</head>

<body>
    <a href="loginPage.php"> Logout </a>


    <h1> This is the main page</h1>

    <br>

    <?php echo "Hello, $user_data[user_name]"; ?>

</body>

</html>