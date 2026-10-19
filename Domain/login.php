<?php

//This will load the database connection and setup a session from db.php.
require_once __DIR__ . '/db.php';

// This will check if the user is already logged in or not 
// if he is logged in this code will take him to profile page or profile.php file.
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit; // This will end the next code if a user is already logged in
}

$error = '';

//This will check if the login form is submitted using POST or not
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the email from the submitted form
    // trim() removes spaces from the beginning and end of the string
    // ?? '' provides an empty string if the field is missing
    $email = trim($_POST['email'] ?? '');

    //Here we will get the password and we are not trimming 
    //Because spaces may be intentional
    $password = $_POST['password'] ?? '';

    //This will prepare a sql query to find the useer by email
    //here ? is a placeholder for the email
    $stmt = $pdo->prepare('SELECT id, email, password, role FROM users WHERE email = ?');

    //This will execute the sql query mentioned above by the submitted email
    $stmt->execute([$email]);

    //Here we will get the matching user record from the database
    //If found it will return the details as an array if not it will return false
    $user = $stmt->fetch();

    //Here we will check for two conditions
    //First if the user acc is existing or not and
    //Second the entered password matches to the stored password hash if yes it will countinue
    if ($user && password_verify($password, $user['password'])) {

        //This will generate a new session id after you logged in successfully
        session_regenerate_id(true);

        //This will store the user id in the session and (int) is used to convert it to integer
        $_SESSION['user_id'] = (int) $user['id'];

        //This will store the role of the user if he is a user or admin
        $_SESSION['role'] = $user['role'];

        //And this will redirect it to the profile page after loging in
        header('Location: profile.php');

        //Stops the script after redirecting to profile page.
        exit;
    }

    //If the email or password is incorrect this will be displayed as the error
    $error = 'Invalid email or password.';
}
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <!-- This is used to display a error if it is not empty -->
    <!-- And the "color : red"  will make the error displayed into red color-->
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!-- This form is used to enter the login credentials in the login form -->
    <!-- POST method sends the form data in the http request body -->
    <form method="POST" action="login.php">

        <!-- In this box the email is entered -->
        <!-- type="email" will automaticly checks if the email is legit or not -->
        <!-- name="email" lets PHP access it through $_POST['email'] -->
        <!-- required prevents an empty submission through normal browser use -->
        <label>Email: <input type="email" name="email" required></label>
        <br><br>

        <!-- This is the password input field -->
        <!-- Characters are masked on the screen because we used type="password"-->
        <!-- PHP receives the value through $_POST['password'] -->
        <label>Password: <input type="password" name="password" required></label>
        <br><br>
        
        <button type="submit">Login</button>
        <!-- This button is used to submit the entered values -->
    </form>

    <!-- This will lead the register page for new users -->
    <a href="register.php">Need an account? Register</a>
</body>
</html>
