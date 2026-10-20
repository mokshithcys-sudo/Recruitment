<?php
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// This will get the logged in user's ID from the session.
// (int) converts the value into an integer.
$userId = (int) $_SESSION['user_id'];

// This variable will store a success message after a successful update.
$message = '';

// This variable will store a success message after a successful update.
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // This will check whether the profile form was submitted or not

    $newUsername = trim($_POST['username'] ?? '');   // This will get the new username and remove surrounding spaces.
    
    $newEmail = trim($_POST['email'] ?? '');         // This will get the new username and remove surrounding spaces.

    // This will get the new password.
    // And an empty password means the user wants to keep the current password.
    $newPassword = $_POST['new_password'] ?? '';     


    // This will check the username and email.
    // And will reject an empty username or an invalid email address.
    if ($newUsername === '' || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a username and a valid email.';
    } else {
        try {

            //If a user wantss to update his/her username email or password this code will 
            //Prepare a sql quary for them
            $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ? WHERE id = ?');
            $stmt->execute([$newUsername, $newEmail, $userId]); //This will execute the quary

            // This will update the password only if a new password was entered
            if ($newPassword !== '') {

                // This will convert a normal password into a hash value
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // This will create a sql quary to update the password entered by the user
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');

                // This code will execute the sql queary to update the password
                $stmt->execute([$hashedPassword, $userId]);
            }

            // This code will check whether a profile picture was submitted.
            // The UPLOAD_ERR_NO_FILE means the user did not select a file.
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] !== UPLOAD_ERR_NO_FILE) {
                
                // This will check weather a file upload is successful or not
                if ($_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
                    
                    $error = 'The profile picture upload failed.';
                
                } else {

                    // This code will define the directory where uploaded images will go.
                    // __DIR__ is the directory containing all PHP file related to the website.
                    $uploadDir = __DIR__ . '/uploads/';

                    // This will check if there is any file/directory for uploading the profile pics
                    //If not it will creat one for uploading 
                    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                        //And if it cant creat a file/directory for uploading the profile pics 
                        //It will throw this exception.
                        throw new RuntimeException('Could not create uploads directory.');
                    }

                    // This will check the actual image file.
                    // getimagesize() examines the file content.
                    // @ suppresses PHP warnings from this function.
                    // tmp_name is used as a temporary location of the uploaded file.
                    $imageInfo = @getimagesize($_FILES['profile_pic']['tmp_name']);

                    //This code checks if the uploaded file is recognized as an image or 
                    //not, if not this code will display an error
                    if ($imageInfo === false) {
                        
                        $error = 'Please upload a valid image file.';
                    
                    }else {

                        //This code will define a image formate for the uploaded file
                        // Each PHP image-type constant maps to a file extension.
                        $allowedTypes = [
                            IMAGETYPE_JPEG => 'jpg',
                            IMAGETYPE_PNG => 'png',
                            IMAGETYPE_GIF => 'gif',
                            IMAGETYPE_WEBP => 'webp'
                        ];

                        // This will get the detected image type from getimagesize().
                        $imageType = $imageInfo[2];

                        // This code will check if the user has uploaded the file in the allowed formate or not
                        if (!isset($allowedTypes[$imageType])) {

                            //If not it will display an error
                            $error = 'Allowed image types: JPG, PNG, GIF, or WEBP.'; 

                        // This code will allow only images under size of 5mb
                        } elseif ($_FILES['profile_pic']['size'] > 5 * 1024 * 1024) {

                            // if not it will return this error
                            $error = 'The image must be 5 MB or smaller.';
                        
                        } else {

                            //This will generate a raandom file name to the uploaded profile pic
                            // random_bytes(16) generates 16 random bytes.
                            // bin2hex() converts those bytes to hexadecimal.
                            // This creates a 32-character random filename.
                            // The extension is selected from the validated image type.
                            $fileName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$imageType];
                            
                            // This code will move the file from the temporary variable to the file/directory
                            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $fileName)) {
                                
                                $error = 'Could not save the profile picture.'; //This error will be displayed 
                                                                                //if it failed to move
                            } else {

                                //This is the sql quary for uploding the pic info to the database
                                //Here the database will store only the file name 
                                //and will not store the picture itself
                                $stmt = $pdo->prepare('UPDATE users SET profile_pic = ? WHERE id = ?');

                                //This will execute the sql quary 
                                $stmt->execute([$fileName, $userId]);
                            }
                        }
                    }
                }
            }

            //If no error occured in the process of uploading this will be displayed
            if ($error === '') {
                
                $message = 'Profile updated successfully!';
            }
        } catch (PDOException $e) {

            //If somthing happened an error message will display
            error_log($e->getMessage());
            
            $error = 'Could not update your profile. The email may already be in use.';
        
        } catch (RuntimeException $e) {
            
            error_log($e->getMessage());
            
            $error = 'A server error occurred while handling your profile picture.';
        }
    }
}

//This retrieve the latest profile details from the database.
// This will also ensures that the page displays the current stored values.
//This is an sql quary given to the database
$stmt = $pdo->prepare('SELECT id, username, email, role, profile_pic FROM users WHERE id = ?');

//This quary is for searching the account details using the users id
$stmt->execute([$userId]);

//This will add all the users details into the array 
//Or will return false if no record is found
$user = $stmt->fetch();

// This will check whether the account still exists in the database.
if (!$user) {

    // Clear the session variables.
    $_SESSION = [];

    // Destroy the current server-side session.
    session_destroy();
    
    // Redirect to the login page.
    header('Location: login.php');
    exit;
}

// This code will get the users profile pic and if it is not there it will leave it empty
$profilePic = $user['profile_pic'] ?? '';

//This code will creat a url to display the profile pic and it will only creat when it is not empty
$profilePicUrl = ($profilePic !== '' && $profilePic !== 'default.png')

    // Here basename() removes directory components from the filename.
    // And rawurlencode() safely encodes the filename for use in a URL.
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

    <!-- Display the user's role.
         htmlspecialchars() escapes special HTML characters.
         (string) converts the role value to a string. -->
    <p>Role: <strong><?= htmlspecialchars((string) $user['role'], ENT_QUOTES, 'UTF-8') ?></strong></p>

    <nav>

        <!-- Link to the user's profile page. -->
        <a href="profile.php">My Profile</a> |

        <!-- This will display the Admin Panel link only for admin users. -->
        <?php if (($user['role'] ?? '') === 'admin'): ?>
            <a href="admin.php">Admin Panel</a> |
        <?php endif; ?>

        <!-- This will link to the logout script. -->
        <a href="logout.php">Logout</a>
    </nav>
    <hr>

    <!-- This will display any message from above code -->
    <?php if ($message !== ''): ?>
        <p style="color: green;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!-- This will display any error happned -->
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!-- This code will display the profile picture if a valid URL was constructed. -->
    <?php if ($profilePicUrl !== ''): ?>
        <img src="<?= htmlspecialchars($profilePicUrl, ENT_QUOTES, 'UTF-8') ?>"
             alt="Profile picture" width="100" height="100">
    
    <?php else: ?>
        <!-- This message will be displayed if there is no custome profile picture -->
        <p>No profile picture uploaded.</p>
    
    <?php endif; ?>

        <!-- This will create the profile-update form.
         POST sends the submitted data to profile.php.
         multipart/form-data is required for file uploads. -->
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

        <!-- If a user want to update any of his credentials he can enter them and 
            and will click on this submit button to update them-->
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
