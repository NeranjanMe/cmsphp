<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];
$author = $_SESSION['username'];

// Input validation
if (empty($title) || empty($content) || empty($category)) {
    die("Title, content and category are required");
}

// Prepared statement to prevent SQL Injection
$stmt = $db->prepare("INSERT INTO posts (title, content, category_id, author) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssis', $title, $content, $category, $author);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Success! The post was created.
    header("Location: index.php"); // Redirect to the dashboard
} else {
    // Error! The creation failed. Handle this error appropriately for your application.
    die("Post creation failed");
}
