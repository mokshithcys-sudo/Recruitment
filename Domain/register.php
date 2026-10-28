<?php

//This will load the database connection and session setup
require __DIR__ . "/db.php";


//This will check if the user is already logged in if yes it will take him to the profile page
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
    }   

$error = '';

// It is used to register a new user and get his information using POST  method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $plainPassword = $_POST['password'] ?? '';

    // This code will check if the username and email entered is valid 
    // And it will also filter any special chars in it
    if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $plainPassword === '') {
        $error = 'Please enter a username, a valid email, and a password.';
    } else {
        try {

            //This will convert the entered password into a hash value
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            //This is the sql quary to register the user and add his details into the database
            $stmt = $pdo->prepare(
                'INSERT INTO users (username, email, password) VALUES (?, ?, ?)'
            );

            //This will execute the sql quary to add the details
            $stmt->execute([$username, $email, $hashedPassword]);

            // This will get the new users id and role from the database
            // This will start his session on his id
            $userId = (int) $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT id, role FROM users WHERE id = ?');
            $stmt->execute([$userId]);
            $user = $stmt->fetch();

            //If we cant retreve the details of the new user this error will be displayed
            if (!$user) {
                throw new RuntimeException('Could not load the newly created account.');
            }

            //This will generate a new sesssion id after completing the registration
            //And this will also delete the old session
            session_regenerate_id(true);

            //This will store the users id and to start his session
            $_SESSION['user_id'] = (int) $user['id'];

            //This will store the role of the user
            $_SESSION['role'] = $user['role'];

            //This will take him to the profile page of the user
            header('Location: profile.php');
            exit;

        //IF any error happned this will give the kind of error happned 
        // Like for different error the error variable store different error messsage 
        } catch (PDOException $e) {

            //This message will be stored and displayed if there is any technical error in the database
            // Like if a same email is used to register again this error message will display
            error_log($e->getMessage());
            $error = 'Registration failed. This email may already be registered; please check your details.';
       
        } catch (RuntimeException $e) {

            // This will tell the user to log in if account creation succeeded
            // but the automatic sign-in process could not be completed.
            // For these type of error this message will be displayed
            error_log($e->getMessage());
            $error = 'Your account was created, but automatic sign-in failed. Please log in.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <!-- If there is any error message this will be used to display them -->
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!-- This is registration form where the user can enter his details to complete his registration -->
    <form method="POST" action="register.php">
        <label>
            Username:
            <input type="text" name="username" maxlength="100" required>
        </label>
        <br><br>

        <label>
            Email:
            <input type="email" name="email" maxlength="255" required>
        </label>
        <br><br>

        <label>
            Password:
            <input type="password" name="password" required>
        </label>
        <br><br>

        <button type="submit">Register</button>
    </form>

    <!-- This will tell the user if he is already having a account so that he can login here 
          This will take him to the login page-->
    <a href="login.php">Already have an account? Login</a>
</body>
</html>
