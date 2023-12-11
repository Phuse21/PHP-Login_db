<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']); // unset the session variable after displaying the message
    echo '<div  style="color: lightgreen;">' . $successMessage . '</div>';
    header("refresh:2;url=index.php"); // Redirect to index.php after 10 seconds
}


$user_data = check_login($con);
?>



<!DOCTYPE html>
<html>

<head>
    <title> First task </title>
</head>

<body>
    <button class="Logout-button" style="padding: 10px;
        width: 100px;
        color: black;
        background-color: lightblue;
        border: none;
                cursor: pointer;"
        onmouseover="this.style.backgroundColor='white'; this.style.color='#551a8b'; this.style.fontWeight='bold';"
        onmouseout="this.style.backgroundColor='lightblue'; this.style.border= 'none'; this.style.color='black'; this.style.fontWeight='normal';">
        <a href="loginPage.php"> Logout </a> <br><br>

    </button>



    <h1> This is the main page</h1>

    <br>

    <?php echo "Logged in as, $user_data[user_name]"; ?>

</body>

</html>