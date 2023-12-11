<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

// Check if a success message is present in the query parameters


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];

    if (!empty($email) && !empty($enteredPassword) && !is_numeric($email)) {
        //read from database
        //$query = "select * from users where email = '$email' limit 1";
        $query = "select * from users where email = '$email' limit 1";

        $result = mysqli_query($con, $query);
        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if (password_verify($enteredPassword, $user_data['password'])) {
                    // Set the success message as a query parameter in the URL
                    $successMessage = "Login successful";
                    header("Location: index.php?successMessage=" . urlencode($successMessage));
                    exit();
                } else {
                    echo '<div id="box">' . "Wrong email or password" . '</div>';
                }
            } else {
                echo '<div id="box">' . "Wrong email or password" . '</div>';
            }
        }
    } else {
        echo '<div id="box">' . "Invalid input" . '</div>';
    }
}
?>

<?php
if (isset($_GET['successMessage'])) {
    $successMessage = $_GET['successMessage'];
    echo '<div id="box" style="color:grey;">' . $successMessage . '</div>';
} ?>

<!DOCTYPE html>
<html>

<head>

    <title>Login</title>
</head>

<body>
    <style type="text/css">
    #text {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }



    #box {
        background-color: #f9d6b9;
        margin: auto;
        width: 300px;
        padding: 20px;
        height: fit-content;


    }
    </style>

    <div id="box">

        <form method="post">
            <div style="font-size: 20px; margin: 10px;">Login</div>
            <input id="text" type="text" name="email" placeholder="Enter your Email"> <br><br>
            <input id="text" type="password" name="password" placeholder="Enter your Password"> <br><br>
            <button class="signup-button" style="padding: 10px;
        width: 100px;
        color: black;
        background-color: lightblue;
        border: none;
                cursor: pointer;"
                onmouseover="this.style.backgroundColor='white'; this.style.color='#551a8b'; this.style.fontWeight='bold';"
                onmouseout="this.style.backgroundColor='lightblue'; this.style.border= 'none'; this.style.color='black'; this.style.fontWeight='normal';">
                Login
            </button> <br><br>
            <a href="signUpPage.php"> Don't have an account? Signup</a> <br><br>
        </form>

    </div>
</body>

</html>