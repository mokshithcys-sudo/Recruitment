<?php
require __DIR__ . "/db.php";

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
    }   

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $plainPassword = $_POST['password'] ?? '';

    if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $plainPassword === '') {
        $error = 'Please enter a username, a valid email, and a password.';
    } else {
        try {
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                'INSERT INTO users (username, email, password) VALUES (?, ?, ?)'
            );
            $stmt->execute([$username, $email, $hashedPassword]);

            // Sign in the newly registered user and start their session.
            $userId = (int) $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT id, role FROM users WHERE id = ?');
            $stmt->execute([$userId]);
            $user = $stmt->fetch();

            if (!$user) {
                throw new RuntimeException('Could not load the newly created account.');
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['role'] = $user['role'];

            header('Location: profile.php');
            exit;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            // A duplicate email is a common cause if email has a UNIQUE constraint.
            $error = 'Registration failed. This email may already be registered; please check your details.';
        } catch (RuntimeException $e) {
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

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

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

    <a href="login.php">Already have an account? Login</a>
</body>
</html>