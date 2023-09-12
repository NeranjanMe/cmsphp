<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

$action = $_GET['action'] ?? 'default';
$user_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' || ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'GET')) {
    switch ($action) {
        case 'update_user':
            // Gather data from POST request
            $first_name = $_POST['first_name'];
            $second_name = $_POST['second_name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];

            // Check if all required fields are filled
            if (empty($first_name) || empty($second_name) || empty($surname) || empty($email)) {
                die("Required fields are empty");
            }

            // Update the user's information in the database
            $stmt = $db->prepare("UPDATE users SET first_name = ?, second_name = ?, surname = ?, email = ? WHERE id = ?");
            $stmt->bind_param('ssssi',  $first_name, $second_name, $surname, $email, $user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ../admin/users.php");
            } else {
                die("Error updating user.");
            }
            break;

        case 'add_new_user':
            // Gather data from POST request
            $role = $_POST['role'];
            $username = $_POST['username']; // Add username field
            $first_name = $_POST['first_name'];
            $second_name = $_POST['second_name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
        
            // Check if all required fields are filled
            if (empty($role) || empty($username) || empty($first_name) || empty($second_name) || empty($surname) || empty($email) || empty($password)) {
                die("Required fields are empty");
            }
        
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
            // Insert the new user into the database
            $stmt = $db->prepare("INSERT INTO users (role, username, first_name, second_name, surname, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $role, $username, $first_name, $second_name, $surname, $email, $password_hash);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                header("Location: ../admin/users.php");
            } else {
                die("Error creating user.");
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

            // Update the user's password in the database
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param('si', $password_hash, $user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ../admin/users.php");
            } else {
                die("Error resetting password.");
            }
            break;
            case 'delete':
                // Check if id is set
                if ($user_id === null) {
                    die("ID is not set.");
                }
    
                // Prepare and execute delete statement
                $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
    
                // Check if a row was deleted
                if ($stmt->affected_rows > 0) {
                    header("Location: ../admin/users.php");
                } else {
                    die("Error deleting user.");
                }
                break;
    
            default:
                die("Invalid action.");
        }
    } else {
        die("Invalid request method.");
    }
    ?>