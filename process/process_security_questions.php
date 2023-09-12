<?php
session_start();
require_once '../database/db_connect.php'; 

$db = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];

    // Get the correct answers from the database
    $stmt = $db->prepare("SELECT security_answer1, security_answer2, security_answer3 FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $correct_answers = $result->fetch_assoc();

        // Store user inputs in session
        $_SESSION['answers'] = [
            'answer1' => $_POST['answer1'],
            'answer2' => $_POST['answer2'],
            'answer3' => $_POST['answer3'],
        ];

        // Check if the answers are correct
        $isCorrect = [
            'answer1' => $_POST['answer1'] === $correct_answers['security_answer1'],
            'answer2' => $_POST['answer2'] === $correct_answers['security_answer2'],
            'answer3' => $_POST['answer3'] === $correct_answers['security_answer3'],
        ];

        if ($isCorrect['answer1'] && $isCorrect['answer2'] && $isCorrect['answer3']) {
            // Redirect to reset password page
            header("Location: ../reset_password.php");
            exit;
        } else {
            $_SESSION['error'] = "Incorrect answers to security questions.";
            $_SESSION['isCorrect'] = $isCorrect;
            header("Location: ../answer_security_questions.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "An error occurred. Please try again.";
        header("Location: ../forgot_password.php");
        exit;
    }
} else {
    header("Location: ../forgot_password.php");
    exit;
}