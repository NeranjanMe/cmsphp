<?php

require_once '../database/db_connect.php'; // Add this line at the top of the file

$db = connect_db(); // Use the connect_db() function from db_connect.php

$username = $_POST['username'];
$password = $_POST['password'];

// Input validation
if (empty($username) || empty($password)) {
    die("Username and password are required");
}

// Prepared statement to prevent SQL Injection
// Update the SQL to fetch both the password and the role
$stmt = $db->prepare("SELECT password, role FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_object();

// Check if user exists and password is correct
if ($user && password_verify($password, $user->password)) {
    // Success! User is logged in.
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_role'] = $user->role;  // Store the role in the session
    header("Location: ../dashboard/index");
    exit;
} else {
    // Error! Authentication failed.
    session_start();
    $_SESSION['error'] = "Invalid username or password";
    header("Location: ../login");
    exit;
}

?>
