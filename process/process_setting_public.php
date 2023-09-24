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
$site_name = isset($_POST['site_name']) ? $_POST['site_name'] : '';
$tag_line = isset($_POST['tag_line']) ? $_POST['tag_line'] : '';
$domain_name = isset($_POST['domain_name']) ? $_POST['domain_name'] : '';

// Validate values
if(empty($site_name) || empty($tag_line) || empty($domain_name)) {
    $_SESSION['error_msg'] = 'All fields are required';
    header("Location: ../admin/setting-public.php");
    exit;
}

// Check if settings already exist and decide whether to INSERT or UPDATE
// Assuming there's only one row of settings. Adjust accordingly if not.
$result = $db->query("SELECT 1 FROM settings");
if($result->num_rows > 0) {
    // If settings exist, update
    $stmt = $db->prepare("UPDATE settings SET sitename=?, tagline=?, domain=? WHERE id=1"); // Assuming id=1 is the row you want to update
    $stmt->bind_param('sss', $site_name, $tag_line, $domain_name);
} else {
    // If settings do not exist, insert
    $stmt = $db->prepare("INSERT INTO settings(sitename, tagline, domain) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $site_name, $tag_line, $domain_name);
}

if ($stmt->execute()) {
    $_SESSION['success_msg'] = 'Public Settings saved successfully';
} else {
    $_SESSION['error_msg'] = 'Error saving settings. Try again.';
}

$stmt->close();
$db->close();

// Redirect back to the settings page
header("Location: ../admin/setting-public.php");
?>
