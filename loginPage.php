<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        //read from database
        $query = "select * from users where email = '$email' limit 1";

        $result = mysqli_query($con, $query);
        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            } else {
                echo "Wrong email or password!";
            }
        }


    } else {
        echo "Enter valid information!";
    }
}

?>

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

    #button {
        padding: 10px;
        width: 100px;
        color: white;
        background-color: lightblue;
        border: none;

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
            <input id="button" type="submit" value="Login"> <br><br>
            <a href="signUpPage.php"> Don't have an account? Signup</a> <br><br>
        </form>

    </div>
</body>

</html>