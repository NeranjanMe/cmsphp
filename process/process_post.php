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
    $body = $_POST['body'];
    $language = $_POST['language'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $status = $_POST['status'];
    $author = $_SESSION["username"]; 
    $permalink = $_POST['permalink'];
    
    // manage Image
    if (isset($_FILES['postImage'])) {
    $uploadDirectory = '../uploads/';
    $filename = basename($_FILES["postImage"]["name"]);
    $targetFile = $uploadDirectory . $filename;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["postImage"]["tmp_name"]);
    if($check === false) {
        die("File is not an image.");
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        die("Sorry, file already exists.");
    }

    // Check file size
    if ($_FILES["postImage"]["size"] > 5000000) { // 5 MB
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Upload file
    if (!move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
        die("Sorry, there was an error uploading your file.");
    }
}


    if (empty($title) || empty($category) || empty($body) || empty($language) || empty($status) || empty($permalink)) {
        die("Required fields are empty");
    }

    $stmt = $db->prepare("INSERT INTO posts (title, category, body, meta_title, meta_description, meta_keyword, status, author, language, permalink, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssssss', $title, $category, $body, $meta_title, $meta_description, $meta_keyword, $status, $author, $language, $permalink, $filename);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "New Post successfully Added!";
        header("Location: ../dashboard/post.php"); // Redirect to the posts page
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
        $_SESSION['success_msg'] = "Post successfully Deleted!";
        header("Location: ../dashboard/post.php"); // Redirect to the posts page
    } else {
        die("Error deleting post");
    }
} else {
    die("Invalid request");
}
?>
