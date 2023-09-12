<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new post
    $title = $_POST['title'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $body = $_POST['body'];
    $language = $_POST['language'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $status = $_POST['status'];
    $author = $_SESSION["username"]; // The author of the post is the currently logged in user
    $permalink = $_POST['permalink'];

    if (empty($title) || empty($category) || empty($body) || empty($language) || empty($status) || empty($permalink)) {
        die("Required fields are empty");
    }

    $stmt = $db->prepare("INSERT INTO posts (title, category, tags, body, language, meta_title, meta_description, meta_keyword, status, author,permalink) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param('sssssssssss', $title, $category, $tags, $body, $language, $meta_title, $meta_description, $meta_keyword, $status, $author, $permalink);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/post.php"); // Redirect to the posts page
    } else {
        die("Error adding post");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'delete') {
    // Delete a post
    $id = $_GET['id'];

    if (empty($id)) {
        die("Post ID is required");
    }

    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: ../admin/post.php"); // Redirect to the posts page
    } else {
        die("Error deleting post");
    }
} else {
    die("Invalid request");
}
?>
