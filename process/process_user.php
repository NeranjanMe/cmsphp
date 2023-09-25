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
                $_SESSION['success_msg'] = "User successfully Updated!";
                header("Location: ../dashboard/users.php");
                exit;
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

            try {
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $_SESSION['success_msg'] = "User successfully Created!";
                    header("Location: ../dashboard/users.php");
                    exit;
                } else {
                    die("Error creating user.");
                }
            } catch (mysqli_sql_exception $exception) {
                if ($exception->getCode() == 1062) { // Code for duplicate entry
                    $_SESSION['error_msg'] = "The username '{$username}' already exists.";
                } else {
                    $_SESSION['error_msg'] = "Database error: " . $exception->getMessage();
                }
                header("Location: ../dashboard/users-new.php");
                exit;
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
                $_SESSION['success_msg'] = "User successfully Reset!";
                    header("Location: ../dashboard/users.php");
                    exit;
            } else {
                die("Error resetting password.");
            }
            break;

        case 'delete':
                // Check if id is set
                if ($user_id === null) {
                    die("ID is not set.");
                }
    
                // Get the id of the logged-in user
                $loggedInUser = $_SESSION["username"];
                $loggedInUserIdQuery = "SELECT id FROM users WHERE username = ?";
                $stmtLoggedInUser = $db->prepare($loggedInUserIdQuery);
                $stmtLoggedInUser->bind_param('s', $loggedInUser);
                $stmtLoggedInUser->execute();
                $result = $stmtLoggedInUser->get_result();
                $userData = $result->fetch_assoc();
                $loggedInUserId = $userData['id'];

                // Ensure logged-in user doesn't delete their own account
                if ($user_id == $loggedInUserId) {
                    $_SESSION['error_msg'] = "You cannot delete your own account for security reasons.";
                    header("Location: ../dashboard/users.php");
                    exit;
                }

                // Prepare and execute delete statement
                $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param('i', $user_id);
                $stmt->execute();

                // Check if a row was deleted
                if ($stmt->affected_rows > 0) {
                    $_SESSION['success_msg'] = "User successfully deleted!";
                    header("Location: ../dashboard/users.php");
                    exit;
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