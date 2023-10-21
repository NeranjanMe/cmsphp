<?php
// Start the session and connect to the database
session_start();
require_once '../database/db_connect.php'; 
$db = connect_db();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username from the session and password inputs from the POST request
    $username = $_SESSION['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password matches the confirmed password
    if ($new_password === $confirm_password) {
        // If matched, hash the new password and update it in the database for the current user
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param('ss', $hashed_password, $username);
        $stmt->execute();
        
        // Check if password update was successful and provide appropriate feedback
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Your password has been reset. Please login with your new password.";
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = "An error occurred. Please try again.";
            header("Location: ../reset_password.php");
        }
    } else {
        // If passwords do not match, redirect back to the reset password page with an error
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../reset_password.php");
    }
} else {
    // If the request is not POST, redirect to the login page
    header("Location: ../login.php");
}
?>
