<?php

//This will load the db.php and will initilize the session and database connection
require_once __DIR__ . '/db.php';


//Since we want to end the session assigning an empty array clears all the 
//Login info from current session
$_SESSION = [];

// This is used to get the session cookies and for expiring them in the browser
if (ini_get('session.use_cookies')) {

    // This will get the current session cookie settings.
    // These settings include the cookie's path, domain,
    // secure flag, and HttpOnly flag.
    $params = session_get_cookie_params();

    // This will expire the session cookie in the browser.
    // And setcookie() sends instructions to the browser
    // to update or remove the existing session cookie.
    setcookie(
        session_name(),           // This gets the name of the cookie
        '',                       // This will set its value to an empty sting
        time() - 42000,           // This will set an expiration time
        $params['path'],          // Preserve the original cookie path
        $params['domain'],        // Preserve the original cookie domain
        $params['secure'],        // Preserve the HTTPS-only setting
        $params['httponly']       // Preserve the JavaScript restriction
    );
}

// This code will destroy the current server-side session.
// And also removes the session data stored by PHP on the server.
session_destroy();

//This will again lead to the login page
header('Location: login.php');
// This will stop the script
exit;
?>
