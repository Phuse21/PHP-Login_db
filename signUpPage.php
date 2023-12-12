<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

// Check if an error message is stored in the session
if (isset($_SESSION['error_message'])) {
    echo '<div id="box">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Clear the error message from the session
}




// Initialize variables
$email = $phone_number = $first_name = $last_name = $gender = $date_of_birth = $user_name = $password = $confirm_password = '';
$email_error = $email_error1 = $phone_number_error = $user_name_error = $password_error = $confirm_password_error = '';
$hashedPassword = '';
$hasUppercase = false;
$hasLowercase = false;
$hasNumber = false;
$hasSymbol = false;
$hasMinLength = false;

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



    //Encrypt password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    // Check if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false && !empty($email)) {
        $email_error = "Invalid email";
    } else {


        // Check if email is already in use
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $email_error1 = "Email address is already in use";

        } else {
            // Check if username is already in the database
            $query = "SELECT * FROM users WHERE user_name = '$user_name'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $user_name_error = "Username has already been taken";

            }
            // Check if phone number is already in the database
            $query = "SELECT * FROM users WHERE phone_number = '$phone_number'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $phone_number_error = "Phone number already exists";

            } else {

                // Check if the password meets the strength criteria
                $hasUppercase = preg_match('/[A-Z]/', $password);
                $hasLowercase = preg_match('/[a-z]/', $password);
                $hasNumber = preg_match('/[0-9]/', $password);
                $hasSymbol = preg_match('/[!@#$%^&*()_+\-=[\]{};:\'\\\\"|,.<>\/?]/', $password);
                $hasMinLength = strlen($password) >= 8;

                if (!$hasUppercase || !$hasLowercase || !$hasNumber || !$hasSymbol || !$hasMinLength) {
                    $password_error = "Password does not meet the strength criteria";

                } else {


                    if ($password != $confirm_password) {
                        $confirm_password_error = "Passwords do not match";

                    } else {



                        //save to database

                        $user_id = random_num(20);
                        $query = "INSERT INTO users (user_id, email, phone_number, first_name, last_name, gender, date_of_birth, user_name, password) VALUES ('$user_id', '$email', '$phone_number', '$first_name', '$last_name', '$gender', '$date_of_birth', '$user_name', '$hashedPassword')";

                        if (mysqli_query($con, $query) && $hasUppercase && $hasLowercase && $hasNumber && $hasSymbol && $hasMinLength) {

                            // Set the success message in a query parameter
                            $successMessage = "Account created successfully";
                            $redirectUrl = "loginPage.php?successMessage=" . urlencode($successMessage);

                            // Delay redirect
                            sleep(2); // 2 seconds



                            // Redirect to the login page with the success message
                            header("Location: " . $redirectUrl);
                            exit();
                        } else {
                            // Display an error message if the account creation fails
                            echo "Error: " . mysqli_error($con);
                        }
                    }
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
    < </head>

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

    .error {
        color: #af4242;
        background-color: #f9d6b9;
        border-radius: 3px;

        font-size: 14px;
        width: 290px;

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
        font-size: 12px;
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

        <form action="" method="post">
            <div style="font-size: 20px; margin: 10px;">Signup</div>
            <p class="error email-error">
                <?php echo $email_error1; ?>
            </p>
            <input id="email" type="text" name="email" placeholder="Enter your Email" value="<?php echo $email; ?>"
                required>

            <p class="error phone_number-error">
                <?php echo $phone_number_error; ?>
            </p>
            <input id="phone_number" type="text" name="phone_number" placeholder="Enter your Phone Number"
                value="<?php echo $phone_number; ?>" required> <br><br>

            <input id="first_name" type="text" name="first_name" placeholder="Enter First Name"
                value="<?php echo $first_name; ?>" required>
            <br><br>
            <input id="last_name" type="text" name="last_name" placeholder="Enter Last Name"
                value="<?php echo $last_name; ?>" required>
            <br><br>
            <div>
                <input type="radio" id="male" name="gender" value="male" checked>
                <label for="male">Male</label>
            </div>
            <div>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label>
            </div><br><br>
            <label for="date_of_birth">Date of birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required> <br><br>
            <p class="error user_name-error">
                <?php echo $user_name_error; ?>
            </p>
            <input id="user_name" type="text" name="user_name" placeholder="Enter User Name"
                value="<?php echo $user_name; ?>" required>

            <p class="error password-error">
                <?php echo $password_error; ?>
            </p>
            <input type="password" id="password_validation" name="password" placeholder="Enter Password"
                value="<?php echo $password; ?>" required>

            <div class="password-strength">
                <ul>
                    <li><span></span>Uppercase</li>
                    <li><span></span>Lowercase</li>
                    <li><span></span>Number</li>
                    <li><span></span>Special Character</li>
                    <li><span></span>8 or more characters</li>
                </ul><br>
            </div>
            <p class="error confirm_password-error">
                <?php echo $confirm_password_error; ?>
            </p>
            <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm your Password"
                value="<?php echo $confirm_password; ?>" required> <br><br>



            <button class="signup-button" style="padding: 10px;
        width: 100px;
        color: black;
        background-color: lightblue;
        border: none;
                cursor: pointer;"
                onmouseover="this.style.backgroundColor='white'; this.style.color='#551a8b'; this.style.fontWeight='bold';"
                onmouseout="this.style.backgroundColor='lightblue'; this.style.border= 'none'; this.style.color='black'; this.style.fontWeight='normal';">
                Signup
            </button> <br><br>
            <a href="loginPage.php"> Already created an account? Login</a> <br><br>

        </form>




    </div>

    <script>
    const passwordInput = document.getElementById('password_validation');
    const passwordStrength = document.querySelector('.password-strength');


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