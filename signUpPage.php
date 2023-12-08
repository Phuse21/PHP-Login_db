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
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    //check if user exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo '<div id="box">' . "User already exists" . '</div>';
    } else {
        // Check if username is already in the database
        $query = "SELECT * FROM users WHERE user_name = '$user_name'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div id="box">' . "Username has already been taken" . '</div>';
        } else {
            // Check if username is already in the database
            $query = "SELECT * FROM users WHERE phone_number = '$phone_number'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div id="box">' . "Phone number already exists" . '</div>';
            } else {

                if (!empty($email) && !empty($phone_number) && !empty($first_name) && !empty($last_name) && !empty($gender) && !empty($date_of_birth) && !empty($user_name) && !empty($password) && !is_numeric($user_name) && !is_numeric($email)) {
                    //save to database
                    $user_id = random_num(20);
                    $query = "insert into users (user_id, email, phone_number, first_name, last_name, gender, date_of_birth,  user_name, password) values ('$user_id', '$email', '$phone_number', '$first_name', '$last_name', '$gender', '$date_of_birth', '$user_name', '$password')";

                    mysqli_query($con, $query);

                    header("Location: loginPage.php");


                } else {
                    echo '<div id="box">' . "Invalid input" . '</div>';
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
            <label>
                <input type="radio" name="gender" value="male">
                Male
            </label>
            <label>
                <input type="radio" name="gender" value="female">
                Female
            </label> <br><br>
            <label for="date_of_birth">Date of birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth"> <br><br>
            <input id="text" type="text" name="user_name" placeholder="Enter User Name"> <br><br>
            <input id="text" type="password" name="password" placeholder="Enter your Password"> <br><br>

            <button class="signup-button" style="padding: 10px;
        width: 100px;
        color: black;
        background-color: lightblue;
        border: none;
                cursor: pointer;" onmouseover="this.style.backgroundColor='white'; this.style.color='#551a8b';
                this.style.fontWeight='bold'" onmouseout="this.style.backgroundColor='lightblue'; 
                this.style.border= 'none'; 
                this.style.color='black';
                this.style.fontWeight='normal';">
                Sign Up
            </button> <br><br>
            <a href="loginPage.php"> Already created an account? Login</a> <br><br>
        </form>

    </div>
</body>

</html>