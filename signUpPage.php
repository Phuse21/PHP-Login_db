<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    //check if user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "User already exists";
    } else {
        // Check if username is already in the database
        $query = "SELECT * FROM users WHERE user_name = '$user_name'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "Username has already been taken";
        } else {
            // Check if username is already in the database
            $query = "SELECT * FROM users WHERE phone_number = '$phone_number'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "Phone number already exists";
            } else {

                if (!empty($email) && !empty($phone_number) && !empty($first_name) && !empty($last_name) && !empty($user_name) && !empty($password) && !is_numeric($user_name)) {
                    //save to database
                    $user_id = random_num(20);
                    $query = "insert into users (user_id, email, phone_number, first_name, last_name, user_name, password) values ('$user_id', '$email', '$first_name', '$last_name', '$user_name', '$password')";

                    mysqli_query($con, $query);

                    header("Location: loginPage.php");


                } else {
                    echo "Invalid Information";
                } {
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>

    <title>Signup</title>
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
            <div style="font-size: 20px; margin: 10px;">Signup</div>
            <input id="text" type="text" name="email" placeholder="Enter your Email"> <br><br>
            <input id="text" type="text" name="phone_number" placeholder="Enter your Phone Number"> <br><br>
            <input id="text" type="text" name="first_name" placeholder="Enter First Name"> <br><br>
            <input id="text" type="text" name="last_name" placeholder="Enter Last Name"> <br><br>
            <input id="text" type="text" name="user_name" placeholder="Enter User Name"> <br><br>
            <input id="text" type="password" name="password" placeholder="Enter your Password"> <br><br>
            <input id="button" type="submit" value="Signup"> <br><br>
            <a href="loginPage.php"> Already created an account? Login</a> <br><br>
        </form>

    </div>
</body>

</html>