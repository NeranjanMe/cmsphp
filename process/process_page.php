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
    // Fetch POST data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $meta_title = $_POST['meta_title'];
$meta_keyword = $_POST['meta_keyword'];
$meta_description = $_POST['meta_description'];


    if (empty($title) || empty($content) || empty($slug)) {
        die("Required fields are empty");
    }

    // Check if page_id is set for update
    if (isset($_POST['page_id']) && !empty($_POST['page_id'])) {
        $page_id = $_POST['page_id'];

        // Update page
        $stmt = $db->prepare("UPDATE pages SET title=?, content=?, slug=?, meta_title=?, meta_keyword=?, meta_description=?, updated_at=NOW() WHERE id=?");
$stmt->bind_param('ssssssi', $title, $content, $slug, $meta_title, $meta_keyword, $meta_description, $page_id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_msg'] = "Page successfully Updated!";
            header("Location: ../dashboard/page.php"); // Redirect to the pages page
        } else {
            die("Error updating page");
        }
    } else {
        // Insert new page
        $stmt = $db->prepare("INSERT INTO pages (title, content, slug, meta_title, meta_keyword, meta_description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
$stmt->bind_param('ssssss', $title, $content, $slug, $meta_title, $meta_keyword, $meta_description);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_msg'] = "New Page successfully Added!";
            header("Location: ../dashboard/page.php"); // Redirect to the pages page
        } else {
            die("Error adding page");
        }
    }
} 

elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'delete') {
    $id = $_GET['id'];

    if (empty($id)) {
        die("Page ID is required");
    }

    // Delete the page from the database
    $stmt = $db->prepare("DELETE FROM pages WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "Page successfully Deleted!";
        header("Location: ../dashboard/page.php"); // Redirect to the pages page
    } else {
        die("Error deleting page");
    }
} else {
    die("Invalid request");
}
?>
