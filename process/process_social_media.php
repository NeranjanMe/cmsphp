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
$facebook = isset($_POST['facebook']) ? $_POST['facebook'] : '';
$twitter = isset($_POST['twitter']) ? $_POST['twitter'] : '';
$instagram = isset($_POST['instagram']) ? $_POST['instagram'] : '';
$linkedin = isset($_POST['linkedin']) ? $_POST['linkedin'] : '';
$youtube = isset($_POST['youtube']) ? $_POST['youtube'] : '';

// Validate values
if(empty($facebook) || empty($twitter) || empty($instagram) || empty($linkedin) || empty($youtube)) {
    $_SESSION['error_msg'] = 'All fields are required';
    header("Location: ../dashboard/social-media.php");
    exit;
}

// Check if social media settings already exist and decide whether to INSERT or UPDATE
// Assuming there's only one row of settings. Adjust accordingly if not.
$result = $db->query("SELECT 1 FROM socialmedia");
if($result->num_rows > 0) {
    // If settings exist, update
    $stmt = $db->prepare("UPDATE socialmedia SET facebook=?, twitter=?, instagram=?, linkedin=?, youtube=? LIMIT 1");
    $stmt->bind_param('sssss', $facebook, $twitter, $instagram, $linkedin, $youtube);
} else {
    // If settings do not exist, insert
    $stmt = $db->prepare("INSERT INTO socialmedia(facebook, twitter, instagram, linkedin, youtube) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $facebook, $twitter, $instagram, $linkedin, $youtube);
}

if ($stmt->execute()) {
    $_SESSION['success_msg'] = 'Social Media Settings saved successfully';
} else {
    $_SESSION['error_msg'] = 'Error saving settings. Try again.';
}

$stmt->close();
$db->close();

// Redirect back to the social media settings page
header("Location: ../dashboard/social-media.php");
?>
