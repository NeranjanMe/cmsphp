<?php
// Start a new or resume an existing session
session_start(); 

// Include database connection script
require_once '../database/db_connect.php'; 

// Ensure that user data from the first registration step is available in the session
if (!isset($_SESSION['step1_data'])) {
    header("Location: ../register.php");
    exit;
}

// Connect to the database
$db = connect_db();

// Extract user details provided in the first registration step from the session
$username = $_SESSION['step1_data']['username'];
$email = $_SESSION['step1_data']['email'];
$password = $_SESSION['step1_data']['password'];
$first_name = $_SESSION['step1_data']['firstName'];
$second_name = $_SESSION['step1_data']['lastName'];
$surname = $_SESSION['step1_data']['surname'];

// Fetch security questions and answers from the POST request (presumably the second registration step)
$security_question1 = $_POST['security_question1'];
$security_answer1 = $_POST['security_answer1'];
$security_question2 = $_POST['security_question2'];
$security_answer2 = $_POST['security_answer2'];
$security_question3 = $_POST['security_question3'];
$security_answer3 = $_POST['security_answer3'];

// Check if the given username already exists in the database to prevent duplicate registrations
$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Redirect back to the registration page with an error if the username is already taken
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
    // If the username is unique, hash the password and store the user details, including security questions and answers, into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert the new user with the role 'Admin'
    $stmt = $db->prepare("INSERT INTO users (username, email, password, role, first_name, second_name, surname, security_question1, security_answer1, security_question2, security_answer2, security_question3, security_answer3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $role = 'Admin';
    $stmt->bind_param('sssssssssssss', $username, $email, $hashed_password, $role, $first_name, $second_name, $surname, $security_question1, $security_answer1, $security_question2, $security_answer2, $security_question3, $security_answer3);
    $stmt->execute();

    // Check if the user was successfully registered
    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Registration successful! You can now log in as an admin.";
        header("Location: ../login.php"); 
        exit;
    } else {
        // Display an error if registration failed
        die("Registration failed");
    }
}
?>
