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
    
    // Upload Image
    if (isset($_FILES['postImage'])) {
        $uploadDirectory = '../uploads/';
        $imageFileType = strtolower(pathinfo($_FILES["postImage"]["name"], PATHINFO_EXTENSION));
        
        // Convert title to lowercase, replace spaces with hyphens
        $modifiedTitle = strtolower(str_replace(' ', '-', $title));
        $uniqueNumber = time(); // Current timestamp for uniqueness
        
        // Create the new filename
        $filename = $modifiedTitle . '-' . $uniqueNumber . '.' . $imageFileType;
        $targetFile = $uploadDirectory . $filename;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["postImage"]["tmp_name"]);
        if($check === false) {
            die("File is not an image.");
        }
    
        // Check file size
        if ($_FILES["postImage"]["size"] > 5000000) { // 5 MB
            die("Sorry, your file is too large.");
        }
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
    
        // Check if file already exists (Though it's highly unlikely due to the unique timestamp)
        if (file_exists($targetFile)) {
            die("Unexpected error: file already exists.");
        }
    
        // Upload file
        if (!move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
            die("Sorry, there was an error uploading your file.");
        }
    }



    if (empty($title) || empty($category) || empty($body) || empty($language) || empty($status) || empty($permalink)) {
        die("Required fields are empty");
    }

    // Retrieve the scheduled date from the form
    if (isset($_POST['scheduled_date']) && !empty($_POST['scheduled_date'])) {
        $status = "schedule"; // set status to schedule when a post is scheduled
        $scheduled_date = $_POST['scheduled_date'];
        } else {
            $status = $_POST['status'];
            $scheduled_date = null;
    }

    
    // Insert post
$stmt = $db->prepare("INSERT INTO posts (title, category, body, meta_title, meta_description, meta_keyword, status, author, language, permalink, image, scheduled_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssssssssss', $title, $category, $body, $meta_title, $meta_description, $meta_keyword, $status, $author, $language, $permalink, $filename, $scheduled_date);
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
    
    // Step 1: Retrieve the filename of the image associated with the post
    $imgStmt = $db->prepare("SELECT image FROM posts WHERE id = ?");
    $imgStmt->bind_param('i', $id);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $post = $imgResult->fetch_assoc();
    
    if (!$post || empty($post['image'])) {
        die("No post found with the given ID or post has no associated image.");
    }
    
    $filename = $post['image'];

    // Step 2: Delete the post from the database
    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Step 3: Delete the associated image from the server
        $filePath = "../uploads/" . $filename;
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $_SESSION['success_msg'] = "Post and its associated image successfully Deleted!";
        header("Location: ../dashboard/post.php"); // Redirect to the posts page
    } else {
        die("Error deleting post");
    }
} else {
    die("Invalid request");
}

?>
