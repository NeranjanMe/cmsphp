<?php
// Start the session and connect to the database
session_start();
require_once '../database/db_connect.php'; 
$db = connect_db();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];

    // Retrieve the correct answers to security questions for the given username from the database
    $stmt = $db->prepare("SELECT security_answer1, security_answer2, security_answer3 FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $correct_answers = $result->fetch_assoc();

        // Store user's provided answers in the session
        $_SESSION['answers'] = [
            'answer1' => $_POST['answer1'],
            'answer2' => $_POST['answer2'],
            'answer3' => $_POST['answer3'],
        ];

        // Compare the user's answers with the correct answers from the database
        $isCorrect = [
            'answer1' => $_POST['answer1'] === $correct_answers['security_answer1'],
            'answer2' => $_POST['answer2'] === $correct_answers['security_answer2'],
            'answer3' => $_POST['answer3'] === $correct_answers['security_answer3'],
        ];

        if ($isCorrect['answer1'] && $isCorrect['answer2'] && $isCorrect['answer3']) {
            // If all answers are correct, redirect to the reset password page
            header("Location: ../reset_password.php");
            exit;
        } else {
            // If any answers are incorrect, set an error message and redirect back to the security questions page
            $_SESSION['error'] = "Incorrect answers to security questions.";
            $_SESSION['isCorrect'] = $isCorrect;
            header("Location: ../answer_security_questions.php");
            exit;
        }
    } else {
        // Set an error if there's an issue retrieving security answers from the database
        $_SESSION['error'] = "An error occurred. Please try again.";
        header("Location: ../forgot_password.php");
        exit;
    }
} else {
    // If the request is not POST, redirect to the forgot password page
    header("Location: ../forgot_password.php");
    exit;
}
?>
