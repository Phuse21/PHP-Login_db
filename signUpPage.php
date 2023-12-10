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
    $confirm_password = $_POST['confirm_password'];

    // Check if the password meets the strength criteria
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSymbol = preg_match('/[!@#$%^&*()_+\-=[\]{};:\'\\\\"|,.<>\/?]/', $password);
    $hasMinLength = strlen($password) >= 8;


    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false && !empty($email)) {
        echo '<div id="box">' . "Invalid email" . '</div>';
    } else {
        error_log('Email is valid');
    }
    ;


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
            // Check if phone number is already in the database
            $query = "SELECT * FROM users WHERE phone_number = '$phone_number'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div id="box">' . "Phone number already exists" . '</div>';
            } else
                if (!$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSymbol || !$hasMinLength) {
                    echo '<div id="box">' . "Password does not meet the strength criteria" . '</div>';

                } else
                    if ($password != $confirm_password) {
                        echo '<div id="box">' . "Passwords do not match" . '</div>';
                    } else

                        if (!empty($email) && !empty($phone_number) && !empty($first_name) && !empty($last_name) && !empty($gender) && !empty($date_of_birth) && !empty($user_name) && !empty($password) && !is_numeric($user_name) && !is_numeric($email) && $password == $confirm_password) {
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

?>




<!DOCTYPE html>
<html>

<head>


    <title>Signup</title>
</head>

<body>
    <style type="text/css">
    #email {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #phone_number {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #first_name {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #last_name {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #user_name {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #confirm_password {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;


    }

    #password_validation {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;
    }



    .password-strength {
        display: none;
    }

    .password-strength ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .password-strength ul li {

        color: red;
        font-weight: 50;
    }

    .password-strength ul li.active {
        color: green;
    }


    .password-strength ul li span:before {
        content: "\2716";
        padding-right: 5px;
    }

    .password-strength ul li.active span:before {
        content: "\2713";
        padding-right: 5px;
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
            <input id="email" type="text" name="email" placeholder="Enter your Email"> <br><br>
            <input id="phone_number" type="text" name="phone_number" placeholder="Enter your Phone Number"> <br><br>
            <input id="first_name" type="text" name="first_name" placeholder="Enter First Name"> <br><br>
            <input id="last_name" type="text" name="last_name" placeholder="Enter Last Name"> <br><br>
            <div>
                <input type="radio" id="male" name="gender" value="male" checked>
                <label for="male">Male</label>
            </div>
            <div>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label>
            </div><br><br>
            <label for="date_of_birth">Date of birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth"> <br><br>
            <input id="user_name" type="text" name="user_name" placeholder="Enter User Name"> <br><br>
            <input id="password_validation" type="password" name="password" placeholder="Enter Password">
            <div class="password-strength">
                <ul>
                    <li><span></span>Uppercase</li>
                    <li><span></span>Lowercase</li>
                    <li><span></span>Number</li>
                    <li><span></span>Special Character</li>
                    <li><span></span>8 or more characters</li>
                </ul>
            </div><br><br>
            <input id="confirm_password" type="password" name="confirm_password"
                placeholder="Confirm your Password"><br><br>


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
            <a href="loginPage.php"> Already created an account? Login</a> <br><br>
        </form>


    </div>

    <script>
    const passwordInput = document.getElementById('password_validation');
    const passwordStrength = document.querySelector('.password-strength');
    const signUpButton = document.querySelector('.signup-button');

    passwordInput.addEventListener('focus', function() {
        passwordStrength.style.display = 'inline-block';
    });

    passwordInput.addEventListener('blur', function() {
        passwordStrength.style.display = 'none';
    });

    const passwordStrengthItems = document.querySelectorAll('.password-strength ul li');

    passwordInput.addEventListener('input', function() {

        const inputValue = passwordInput.value;
        const hasUppercase = /[A-Z]/.test(inputValue);
        const hasLowercase = /[a-z]/.test(inputValue);
        const hasNumber = /\d/.test(inputValue);
        const hasSymbol = /[\W_]/.test(inputValue);
        const hasMinLength = inputValue.length >= 8;

        passwordStrengthItems[1].classList.toggle('active', hasLowercase);
        passwordStrengthItems[0].classList.toggle('active', hasUppercase);
        passwordStrengthItems[2].classList.toggle('active', hasNumber);
        passwordStrengthItems[3].classList.toggle('active', hasSymbol);
        passwordStrengthItems[4].classList.toggle('active', hasMinLength);


    });
    </script>


</body>

</html>