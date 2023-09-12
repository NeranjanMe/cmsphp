<?php
session_start(); 
require_once '../database/db_connect.php'; 

// Check if step1 data is available in the session
if (!isset($_SESSION['step1_data'])) {
    header("Location: ../register.php");
    exit;
}

$db = connect_db();

// Retrieve step1 data from the session
$username = $_SESSION['step1_data']['username'];
$email = $_SESSION['step1_data']['email'];
$password = $_SESSION['step1_data']['password'];
$first_name = $_SESSION['step1_data']['firstName'];
$second_name = $_SESSION['step1_data']['lastName'];
$surname = $_SESSION['step1_data']['surname'];

// Get security questions and answers from POST request
$security_question1 = $_POST['security_question1'];
$security_answer1 = $_POST['security_answer1'];
$security_question2 = $_POST['security_question2'];
$security_answer2 = $_POST['security_answer2'];
$security_question3 = $_POST['security_question3'];
$security_answer3 = $_POST['security_answer3'];

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
}  
else {
    // Hash the password and insert the new user into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Update the SQL query to include security questions and answers, and set role to 'admin'
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role, first_name, second_name, surname, security_question1, security_answer1, security_question2, security_answer2, security_question3, security_answer3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $role = 'admin';
    $stmt->bind_param('sssssssssssss', $username, $email, $hashed_password, $role, $first_name, $second_name, $surname, $security_question1, $security_answer1, $security_question2, $security_answer2, $security_question3, $security_answer3);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        // Success! The user was registered as admin.
        $_SESSION['success'] = "Registration successful! You can now log in as an admin.";
        header("Location: ../login.php"); // Redirect to the login page
        exit;
    } else {
        // Error! The registration failed.
        die("Registration failed");
    }
}
?>
