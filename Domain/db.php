<?php

// This will start a session if not started before 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//These are the details about my databaswe
$host = "localhost";
$dbname = "user_management";
$username = "phpuser";
$password = "StrongPass123!";

try {
    //Here this code is used to connect to mysql using PDO
    //The PDO means PHP Data Objects, it is used to set up the connection.
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //This code throws errors on failure
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //This will get the rows as an associative arrays.
            PDO::ATTR_EMULATE_PREPARES => false //
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500); //This code will send an server error whose code is 500.
    exit("Database connection failed. Check the server error log.");//This will display the error and exits the code
}
?>
