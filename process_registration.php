<?php
require_once 'db_connect.php'; // Add this line at the top of the file

$db = connect_db(); // Use the connect_db() function from db_connect.php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Input validation
if (empty($username) || empty($password) || empty($email)) {
    die("Username, email, and password are required");
}

// Prepared statement to prevent SQL Injection
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if username already exists
if ($result->num_rows > 0) {
    die("Username already exists");
} else {
    // Hash the password and insert the new user into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $email, $hashed_password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Success! The user was registered. You might want to start a session here or send a confirmation email.
        header("Location: login.php"); // Redirect to the login page or to a "Registration successful" page
    } else {
        // Error! The registration failed. Handle this error appropriately for your application.
        die("Registration failed");
    }
}
