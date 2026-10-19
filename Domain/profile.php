<?php
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = (int) $_SESSION['user_id'];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $newPassword = $_POST['new_password'] ?? '';

    if ($newUsername === '' || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a username and a valid email.';
    } else {
        try {
            $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
            $stmt->execute([$newUsername, $newEmail, $userId]);

            if ($newPassword !== '') {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $stmt->execute([$hashedPassword, $userId]);
            }

            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
                    $error = 'The profile picture upload failed.';
                } else {
                    $uploadDir = __DIR__ . '/uploads/';
                    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                        throw new RuntimeException('Could not create uploads directory.');
                    }

                    // Validate the file content rather than trusting its extension or MIME header.
                    $imageInfo = @getimagesize($_FILES['profile_pic']['tmp_name']);
                    if ($imageInfo === false) {
                        $error = 'Please upload a valid image file.';
                    } else {
                        $allowedTypes = [
                            IMAGETYPE_JPEG => 'jpg',
                            IMAGETYPE_PNG => 'png',
                            IMAGETYPE_GIF => 'gif',
                            IMAGETYPE_WEBP => 'webp'
                        ];

                        $imageType = $imageInfo[2];
                        if (!isset($allowedTypes[$imageType])) {
                            $error = 'Allowed image types: JPG, PNG, GIF, or WEBP.';
                        } elseif ($_FILES['profile_pic']['size'] > 5 * 1024 * 1024) {
                            $error = 'The image must be 5 MB or smaller.';
                        } else {
                            $fileName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$imageType];
                            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $fileName)) {
                                $error = 'Could not save the profile picture.';
                            } else {
                                $stmt = $pdo->prepare('UPDATE users SET profile_pic = ? WHERE id = ?');
                                $stmt->execute([$fileName, $userId]);
                            }
                        }
                    }
                }
            }

            if ($error === '') {
                $message = 'Profile updated successfully!';
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'Could not update your profile. The email may already be in use.';
        } catch (RuntimeException $e) {
            error_log($e->getMessage());
            $error = 'A server error occurred while handling your profile picture.';
        }
    }
}

$stmt = $pdo->prepare('SELECT id, username, email, role, profile_pic FROM users WHERE id = ?');
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

$profilePic = $user['profile_pic'] ?? '';
$profilePicUrl = ($profilePic !== '' && $profilePic !== 'default.png')
    ? 'uploads/' . rawurlencode(basename($profilePic))
    : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile</title>
</head>
<body>
    <h2>My Profile</h2>
    <p>Role: <strong><?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?></strong></p>

    <nav>
        <a href="profile.php">My Profile</a> |
        <?php if (($user['role'] ?? '') === 'admin'): ?>
            <a href="admin.php">Admin Panel</a> |
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
    <hr>

    <?php if ($message !== ''): ?>
        <p style="color: green;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($profilePicUrl !== ''): ?>
        <img src="<?= htmlspecialchars($profilePicUrl, ENT_QUOTES, 'UTF-8') ?>"
             alt="Profile picture" width="100" height="100">
    <?php else: ?>
        <p>No profile picture uploaded.</p>
    <?php endif; ?>

    <form method="POST" action="profile.php" enctype="multipart/form-data">
        <h3>Update Details</h3>

        <label>Username:
            <input type="text" name="username"
                   value="<?= htmlspecialchars((string) $user['username'], ENT_QUOTES, 'UTF-8') ?>" required>
        </label>
        <br><br>

        <label>Email:
            <input type="email" name="email"
                   value="<?= htmlspecialchars((string) $user['email'], ENT_QUOTES, 'UTF-8') ?>" required>
        </label>
        <br><br>

        <label>New password (leave blank to keep current):
            <input type="password" name="new_password">
        </label>
        <br><br>

        <label>Profile picture (JPG, PNG, GIF, WEBP; max 5 MB):
            <input type="file" name="profile_pic" accept="image/jpeg,image/png,image/gif,image/webp">
        </label>
        <br><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
