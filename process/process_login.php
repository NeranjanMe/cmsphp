<?php

// Include the database connection file
require_once '../database/db_connect.php';

// Connect to the database using the function from db_connect.php
$db = connect_db();

// Retrieve username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Validate input: Ensure both username and password are provided
if (empty($username) || empty($password)) {
    die("Username and password are required");
}

// Use a prepared statement to fetch password and role for the provided username
// This helps in preventing SQL Injection attacks
$stmt = $db->prepare("SELECT password, role FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_object();

// Verify the provided password with the hash stored in the database
// Also check if the user exists in the database
if ($user && password_verify($password, $user->password)) {
    // If authentication is successful, start a session and store user details
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_role'] = $user->role;  // Store the user's role in the session
    // Redirect user to the dashboard
    header("Location: ../dashboard/index");
    exit;
} else {
    // If authentication fails, start a session and store error message
    session_start();
    $_SESSION['error'] = "Invalid username or password";
    // Redirect user back to the login page
    header("Location: ../login");
    exit;
}

?>
