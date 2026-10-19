<?php
// Here i included the database and made the required connection to the database.
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {  //This line of code checks if the person is logged in or not
    header('Location: login.php');   //if not it will redirect him to the login.php file 
    exit;                            // or the login page.
}

if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit("Access denied. You must be an admin to view this page. <a href='profile.php'>Go back</a>");
}
//This line of code checks if the person logged in is the admin or not
//if not, it will display a message and sends a 403 message which mean he is forbidden.

$error = ''; //this is a variable and it is used to store any error messages which occur in the future.

// This part of code is used if the admin wants to delete a user
if (isset($_GET['delete_id'])) { //This line will get the user id for deleting his account
    $deleteId = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);

    if (!$deleteId) { //This line checks if the id is valide or not if not it will print a error message
        $error = 'Invalid user ID.';
        
    } elseif ($deleteId === (int) $_SESSION['user_id']) { //This code is used to prevent the admin from deleting
        $error = 'You cannot delete your own account.';   //his account and it will also display this message.
    
    } else {
        //This will start the sql query to delete the selected user
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');

        //This will call the function for deleting the user
        $stmt->execute([$deleteId]); 

        //This will reload the admin page after deleting the user
        header('Location: admin.php');
        exit; //this will stop the php from executing any further code in the current deletion request
    }
}

//This code is used for displaying the users data in a tabular form 
$stmt = $pdo->query('SELECT id, username, email, role, profile_pic FROM users ORDER BY id');

//This is used for storing all users record in the array
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
    <!-- This navigation bar provides My profile and Logout pages -->
    <nav>
        <a href="profile.php">My Profile</a> | 
        <a href="logout.php">Logout</a>
    </nav>
    <hr>

    <!-- This code will display a error message if anything exists -->
    <?php if ($error !== ''): ?>
        <!-- This color function is used to display the error message in red color -->
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!-- This code will display all users details in a tabular form -->
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <!-- This will display the column headings -->
                <th>ID</th><th>Profile</th><th>Username</th>
                <th>Email</th><th>Role</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <!-- This will display the users id -->
                <td><?= (int) $u['id'] ?></td>
                <td>
                    <?php
                    // This will store the profile picture filename
                    $pic = $u['profile_pic'] ?? '';

                    // This will check if the profile picture 
                    // is the uploaded one or a default one
                    if ($pic !== '' && $pic !== 'default.png'):
                    ?>
                        <!-- This will display the profile picture avoiding any HTML injection script -->
                        <img src="uploads/<?= htmlspecialchars(basename($pic), ENT_QUOTES, 'UTF-8') ?>"
                             alt="Profile picture" width="40" height="40">
                    <?php else: ?>
                        <!-- This text will be displayed if there is no picture is uploaded -->
                        No pic
                    <?php endif; ?>
                </td>

                <!-- This will display the username -->
                <td><?= htmlspecialchars((string) $u['username'], ENT_QUOTES, 'UTF-8') ?></td>

                <!-- This will display the users email -->
                <td><?= htmlspecialchars((string) $u['email'], ENT_QUOTES, 'UTF-8') ?></td>

                <!-- This will display the users role which is user or the admin -->
                <td><?= htmlspecialchars((string) $u['role'], ENT_QUOTES, 'UTF-8') ?></td>
                
                <td>
                    <!-- This will show the delete option only for users and not the admin -->
                    <?php if ((int) $u['id'] !== (int) $_SESSION['user_id']): ?>

                        <!-- This code asks for a confirmation before deleting any users account -->
                        <a href="admin.php?delete_id=<?= (int) $u['id'] ?>"
                           onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    
                    <?php else: ?>
                        <!-- This code will display the currently which admin acc is logged in -->
                        <i>Your Account</i>
                    <?php endif; ?>
                </td>
            </tr>
        <!-- This line will finish the looping through the users-->
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
