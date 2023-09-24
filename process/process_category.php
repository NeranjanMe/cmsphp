<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Update existing category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) { 
    $id = $_POST['id'];
    $name = $_POST['name'];

    if (empty($name)) {
        die("Category name is required");
    }

    $stmt = $db->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param('si', $name, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "User successfully Updated!";
        header("Location: ../admin/category.php");
        exit;
    } else {
        die("Error updating category");
    }
} 
// Add new category
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (empty($name)) {
        die("Category name is required");
    }

    $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param('s', $name);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "User successfully Added!";
        header("Location: ../admin/category.php");
        exit;
    } else {
        die("Error adding category");
    }
} 
// Delete a category
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'delete') {

    $id = $_GET['id'];

    if (empty($id)) {
        die("Category ID is required");
    }

    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "User successfully Deleted!";
        header("Location: ../admin/category.php");
        exit;
    } else {
        die("Error deleting category");
    }
} else {
    die("Invalid request");
}
