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
$meta_title = isset($_POST['meta_title']) ? $_POST['meta_title'] : '';
$meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : '';
$meta_description = isset($_POST['meta_description']) ? $_POST['meta_description'] : '';

// Validate values
if(empty($meta_title) || empty($meta_keywords) || empty($meta_description)) {
    $_SESSION['error_msg'] = 'All fields are required';
    header("Location: ../dashboard/meta-data.php");
    exit;
}

// Check if settings already exist and decide whether to INSERT or UPDATE
$result = $db->query("SELECT 1 FROM settings");
if($result->num_rows > 0) {
    // If settings exist, update
    $stmt = $db->prepare("UPDATE settings SET meta_title=?, meta_keywords=?, meta_description=? WHERE id=1");
    $stmt->bind_param('sss', $meta_title, $meta_keywords, $meta_description);
} else {
    // If settings do not exist, insert
    $stmt = $db->prepare("INSERT INTO settings(meta_title, meta_keywords, meta_description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sss',  $meta_title, $meta_keywords, $meta_description);
}

if ($stmt->execute()) {
    $_SESSION['success_msg'] = 'Home Page Meta Data saved successfully';
} else {
    $_SESSION['error_msg'] = 'Error saving Home Page Meta Data. Try again.';
}

$stmt->close();
$db->close();

// Redirect back to the settings page
header("Location: ../dashboard/meta-data.php");
?>
