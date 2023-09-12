<?php
require_once '../database/db_connect.php';
session_start();

if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

$action = $_GET['action'] ?? 'default';
$author_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'update_author':
            // Gather data from POST request
            $username = $_POST['username'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];

            // Check if all fields are filled
            if(empty($username) || empty($first_name) || empty($last_name) || empty($surname) || empty($email)) {
                die("Required fields are empty");
            }

            // Update the database with the new details
            $stmt = $db->prepare("UPDATE author SET username = ?, first_name = ?, last_name = ?, surname = ?, email = ?, updated_date = NOW() WHERE id = ?");
            $stmt->bind_param('sssssi', $username, $first_name, $last_name, $surname, $email, $author_id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                header("Location: ../admin/author.php");
            } else {
                die("Error updating author.");
            }
            break;

        case 'reset_password':
            // Gather data from POST request
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if passwords match
            if ($new_password !== $confirm_password) {
                die("Passwords do not match.");
            }

            // Hash the new password
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the database with the new password
            $stmt = $db->prepare("UPDATE author SET password = ? WHERE id = ?");
            $stmt->bind_param('si', $password_hash, $author_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ../admin/author.php");
            } else {
                echo "Error resetting password.";
            }
            break;

        default:
            die("Invalid action.");
    }
} else {
    die("Invalid request method.");
}
?>
