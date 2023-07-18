<?php

require_once 'db_connect.php'; // Add this line at the top of the file

$db = connect_db(); // Use the connect_db() function from db_connect.php

$username = $_POST['username'];
$password = $_POST['password'];

// Input validation
if (empty($username) || empty($password)) {
    die("Username and password are required");
}

// Prepared statement to prevent SQL Injection
$stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_object();

// Check if user exists and password is correct
if ($user && password_verify($password, $user->password)) {
    // Success! User is logged in. You might want to start a session here.
    session_start();
    $_SESSION['username'] = $username; // You can save the username to the session
    header("Location: dashboard.php"); // Redirect to a logged in page like dashboard.php
} else {
    // Error! Authentication failed. Handle this error appropriately for your application.
    die("Invalid username or password");
}
?>
