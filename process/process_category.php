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

    // Start transaction
    $db->begin_transaction();

    // Fetch the category name for the given ID
    $stmt = $db->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if ($category) {
        $categoryName = $category['name'];
        
        // Fetch the default category name
        $stmt = $db->prepare("SELECT name FROM categories WHERE is_default = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $defaultCategory = $result->fetch_assoc();
        
        if (!$defaultCategory) {
            $db->rollback();
            die("Default category not found");
        }

        $defaultCategoryName = $defaultCategory['name'];

        // Update posts set to this category to the default category
        $stmt = $db->prepare("UPDATE posts SET category = ? WHERE category = ?");
        $stmt->bind_param('ss', $defaultCategoryName, $categoryName);
        $stmt->execute();
        
        // Now, delete the category
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $db->commit();
            $_SESSION['success_msg'] = "Category successfully Deleted! and Updated Post to default Category";
            header("Location: ../admin/category.php");
            exit;
        } else {
            $db->rollback();
            die("Error deleting category");
        }
    } else {
        $db->rollback();
        die("Category not found");
    }
}

