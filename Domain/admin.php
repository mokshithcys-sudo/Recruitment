<?php
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit("Access denied. You must be an admin to view this page. <a href='profile.php'>Go back</a>");
}

$error = '';

// Keep the original self-delete protection. For a production application,
// change deletion to POST with a CSRF token rather than a GET link.
if (isset($_GET['delete_id'])) {
    $deleteId = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);

    if (!$deleteId) {
        $error = 'Invalid user ID.';
    } elseif ($deleteId === (int) $_SESSION['user_id']) {
        $error = 'You cannot delete your own account.';
    } else {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$deleteId]);
        header('Location: admin.php');
        exit;
    }
}

$stmt = $pdo->query('SELECT id, username, email, role, profile_pic FROM users ORDER BY id');
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel - All Users</h2>
    <nav>
        <a href="profile.php">My Profile</a> |
        <a href="logout.php">Logout</a>
    </nav>
    <hr>

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th><th>Profile</th><th>Username</th>
                <th>Email</th><th>Role</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= (int) $u['id'] ?></td>
                <td>
                    <?php
                    $pic = $u['profile_pic'] ?? '';
                    if ($pic !== '' && $pic !== 'default.png'):
                    ?>
                        <img src="uploads/<?= htmlspecialchars(basename($pic), ENT_QUOTES, 'UTF-8') ?>"
                             alt="Profile picture" width="40" height="40">
                    <?php else: ?>
                        No pic
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars((string) $u['username'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $u['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars((string) $u['role'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php if ((int) $u['id'] !== (int) $_SESSION['user_id']): ?>
                        <a href="admin.php?delete_id=<?= (int) $u['id'] ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    <?php else: ?>
                        <i>Your Account</i>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
