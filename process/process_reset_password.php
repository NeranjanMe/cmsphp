<?php
session_start();
require_once '../database/db_connect.php'; 

$db = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Update the password in the database
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param('ss', $hashed_password, $username);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Your password has been reset. Please login with your new password.";
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = "An error occurred. Please try again.";
            header("Location: ../reset_password.php");
        }
    } else {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../reset_password.php");
    }
} else {
    header("Location: ../login.php");
}
?>
