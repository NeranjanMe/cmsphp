<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

function generateSlug($string) {
    $slug = strtolower($string);           // Convert the string to lowercase
    $slug = preg_replace("/[^a-z0-9\s]/", "", $slug);  // Remove any characters that are not alphanumeric or spaces
    $slug = str_replace(" ", "-", $slug);  // Replace spaces with dashes
    return $slug;
}

// Define a function to upload the image
function uploadImage($image, $categoryName) {
    $target_dir = "../uploads/categories/";

    // Create filename based on slugified category name
    $file_extension = pathinfo($image["name"], PATHINFO_EXTENSION);
    $filename = generateSlug($categoryName) . "." . $file_extension;
    $target_file = $target_dir . $filename;

    // Check and move the uploaded file to target directory
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        return $filename;  // Return only the filename with its extension
    } else {
        return false;
    }
}

// Update existing category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    if (empty($name)) {
        die("Category name is required");
    }

    if ($_FILES['image']['size'] > 0) { // if a new image is uploaded
        $imageFilename = uploadImage($_FILES['image'], $name);
        if ($imageFilename) {
            $stmt = $db->prepare("UPDATE categories SET name = ?, image = ? WHERE id = ?");
            $stmt->bind_param('ssi', $name, $imageFilename, $id);
        } else {
            die("Error uploading image");
        }
    } else {
        $stmt = $db->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param('si', $name, $id);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "Category successfully Updated!";
        header("Location: ../dashboard/category.php");
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

    $imageFilename = uploadImage($_FILES['image'], $name);
    if ($imageFilename) {
        $stmt = $db->prepare("INSERT INTO categories (name, image) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $imageFilename);
    } else {
        die("Error uploading image");
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "Category successfully Added!";
        header("Location: ../dashboard/category.php");
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

    // Check if the category to be deleted is the default category
    $stmt = $db->prepare("SELECT is_default FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if ($category['is_default'] == 1) {
        // It's the default category, so do not allow deletion
        $_SESSION['error_msg'] = "Cannot delete the default category. If you want to delete the default category, you must change the default category first.";
        header("Location: ../dashboard/category.php");
        exit;
    }

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
            $_SESSION['success_msg'] = "Category successfully Deleted!";
            header("Location: ../dashboard/category.php");
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
?>
