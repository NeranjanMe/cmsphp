<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch POST values
$openai = isset($_POST['openai']) ? $_POST['openai'] : '';
$delle2 = isset($_POST['delle2']) ? $_POST['delle2'] : '';
$texttovoice = isset($_POST['texttovoice']) ? $_POST['texttovoice'] : '';

// Validate values
if(empty($openai) || empty($delle2) || empty($texttovoice)) {
    $_SESSION['error_msg'] = 'All fields are required';
    header("Location: ../dashboard/setting-api.php");
    exit;
}

// Check if API settings already exist and decide whether to INSERT or UPDATE
// Assuming there's only one row of settings. Adjust accordingly if not.
$result = $db->query("SELECT 1 FROM api");
if($result->num_rows > 0) {
    // If settings exist, update
    $stmt = $db->prepare("UPDATE api SET openai=?, delle2=?, texttovoice=? LIMIT 1");
    $stmt->bind_param('sss', $openai, $delle2, $texttovoice);
} else {
    // If settings do not exist, insert
    $stmt = $db->prepare("INSERT INTO api(openai, delle2, texttovoice) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $openai, $delle2, $texttovoice);
}

if ($stmt->execute()) {
    $_SESSION['success_msg'] = 'API Settings saved successfully';
} else {
    $_SESSION['error_msg'] = 'Error saving settings. Try again.';
}

$stmt->close();
$db->close();

// Redirect back to the settings page
header("Location: ../dashboard/setting-api.php");
?>
