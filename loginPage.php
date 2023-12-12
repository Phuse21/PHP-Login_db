<?php
session_start();

include("connectionPage.php");
include("functionsPage.php");

// Check if an error message is stored in the session
if (isset($_SESSION['error_message'])) {
    echo '<div id="box">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Clear the error message from the session
}


$email = $password = "";
$email_error = $password_error = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $email = $_POST['email'];
    $enteredPassword = $_POST['password'];

    if (!is_numeric($email)) {
        //read from database

        $query = "select * from users where email = '$email' limit 1";

        $result = mysqli_query($con, $query);
        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if (password_verify($enteredPassword, $user_data['password'])) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['successMessage'] = "Login successful";
                    header("Location: index.php");
                    die;
                } else {
                    $password_error = "Wrong Password";
                }
            } else {
                $email_error = "User not found";
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

    #email {
        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin;
        width: 100%;



    }

    #password {
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
            <p class="error email-error">
                <?php echo $email_error; ?>
            </p>
            <input id="email" type="text" name="email" placeholder="Enter your Email" value="<?php echo $email; ?>"
                required><br><br>
            <p class="error password-error">
                <?php echo $password_error; ?>
            </p>
            <input type="password" id="password" name="password" placeholder="Enter Password"
                value="<?php echo $password; ?>" required> <br><br>
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