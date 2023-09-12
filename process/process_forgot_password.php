<?php
session_start();
require_once '../database/db_connect.php';

$db = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // Get the security questions from the database
    $stmt = $db->prepare("SELECT security_question1, security_question2, security_question3 FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $questions = $result->fetch_assoc();

        // Store the username in session to use in the next step
        $_SESSION['username'] = $username;

        // Redirect to a page to answer security questions
        header("Location: ../answer_security_questions.php");
    } else {
        $_SESSION['error'] = "No user found with that username.";
        header("Location: ../forgot_password.php");
    }
} else {
    header("Location: ../forgot_password.php");
}
?>
