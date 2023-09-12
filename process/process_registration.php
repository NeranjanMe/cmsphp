<?php
session_start(); // Move session_start() to the very top
require_once '../database/db_connect.php'; 

$db = connect_db();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


// Prepared statement to prevent SQL Injection
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if username already exists
if ($result->num_rows > 0) {
    $_SESSION['error'] = "Username already exists";
    $_SESSION['input_values'] = [
        'username' => $username,
        'email' => $email,
    ];
    header("Location: ../register.php");
    exit;
}  else {
    // Hash the password and insert the new user into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $email, $hashed_password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Success! The user was registered.
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header("Location: ../login.php"); // Redirect to the login page
        exit;
    } else {
        // Error! The registration failed.
        die("Registration failed");
    }
    
}
