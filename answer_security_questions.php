<?php
session_start();
include 'include/header.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'database/db_connect.php'; 

$db = connect_db();
$username = $_SESSION['username'];

// Get the security questions from the database
$stmt = $db->prepare("SELECT security_question1, security_question2, security_question3 FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $questions = $result->fetch_assoc();
} else {
    header("Location: forgot_password.php");
    exit();
}

if (isset($_SESSION['answers'])) {
    $answers = $_SESSION['answers'];
    unset($_SESSION['answers']);
} else {
    $answers = [
        'answer1' => '',
        'answer2' => '',
        'answer3' => '',
    ];
}

if (isset($_SESSION['isCorrect'])) {
    $isCorrect = $_SESSION['isCorrect'];
    unset($_SESSION['isCorrect']);
} else {
    $isCorrect = [
        'answer1' => false,
        'answer2' => false,
        'answer3' => false,
    ];
}

$error_message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h2>Answer Security Questions</h2>
            
            <form action="process/process_security_questions.php" method="post">
    <!-- Your security questions fields here. Make sure to fetch the questions from the database -->
    <div class="form-group mt-3">
        <label for="question1">Question 1:</label>
        <select class="form-control mt-1" id="question1" name="question1" required>
            <?php echo "<option value=\"{$questions['security_question1']}\">{$questions['security_question1']}</option>"; ?>
        </select>
        <label for="answer1" class="mt-2">Answer:</label>
        <input type="text" class="form-control mt-1 <?php echo $isCorrect['answer1'] ? 'is-valid' : ($answers['answer1'] !== '' ? 'is-invalid' : ''); ?>" id="answer1" name="answer1" value="<?php echo htmlspecialchars($answers['answer1']); ?>" required>
    </div>
    <div class="form-group mt-3">
        <label for="question2">Question 2:</label>
        <select class="form-control mt-1" id="question2" name="question2" required>
            <?php echo "<option value=\"{$questions['security_question2']}\">{$questions['security_question2']}</option>"; ?>
        </select>
        <label for="answer2" class="mt-2">Answer:</label>
        <input type="text" class="form-control mt-1 <?php echo $isCorrect['answer2'] ? 'is-valid' : ($answers['answer2'] !== '' ? 'is-invalid' : ''); ?>" id="answer2" name="answer2" value="<?php echo htmlspecialchars($answers['answer2']); ?>" required>
    </div>
    <div class="form-group mt-3">
        <label for="question3">Question 3:</label>
        <select class="form-control mt-1" id="question3" name="question3" required>
            <?php echo "<option value=\"{$questions['security_question3']}\">{$questions['security_question3']}</option>"; ?>
        </select>
        <label for="answer3" class="mt-2">Answer:</label>
        <input type="text" class="form-control mt-1 <?php echo $isCorrect['answer3'] ? 'is-valid' : ($answers['answer3'] !== '' ? 'is-invalid' : ''); ?>" id="answer3" name="answer3" value="<?php echo htmlspecialchars($answers['answer3']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>

        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>
