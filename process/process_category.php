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
    $slug = strtolower($string);
    $slug = preg_replace("/[^a-z0-9\s]/", "", $slug);
    $slug = str_replace(" ", "-", $slug);
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
    $slug = $_POST['slug'];
    $description = $_POST['description'];

    if (empty($name)) {
        die("Category name is required");
    }

    if ($_FILES['image']['size'] > 0) { // if a new image is uploaded
        $imageFilename = uploadImage($_FILES['image'], $name);
        if ($imageFilename) {
             $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $slug, $description, $id);
        } else {
            die("Error uploading image");
        }
    } else {
        $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
    $stmt->bind_param('sssi', $name, $slug, $description, $id);
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
    $slug = generateSlug($name);
    $description = $_POST['description'];

    if (empty($name)) {
        die("Category name is required");
    }

    $imageFilename = uploadImage($_FILES['image'], $name);
    if ($imageFilename) {
        $stmt = $db->prepare("INSERT INTO categories (name, slug, image, description) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $name, $slug, $imageFilename, $description);
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
    $stmt = $db->prepare("SELECT is_default, name, image FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if ($category['is_default'] == 1) {
        $_SESSION['error_msg'] = "Cannot delete the default category. If you want to delete the default category, you must change the default category first.";
        header("Location: ../dashboard/category.php");
        exit;
    }

    if ($category) {
        $categoryName = $category['name'];
        $categorySlugToDelete = generateSlug($categoryName); // Generate the slug of the category to be deleted
        $imageFilename = $category['image'];
        
        // Delete the image file from the server
        if ($imageFilename) {
            $imagePath = "../uploads/categories/" . $imageFilename;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Fetch the default category slug
        $stmt = $db->prepare("SELECT slug FROM categories WHERE is_default = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $defaultCategory = $result->fetch_assoc();
        $defaultCategorySlug = $defaultCategory['slug'];

        if (!$defaultCategory) {
            die("Default category not found");
        }

        // Update posts set to this category to the default category using the slug
        $stmt = $db->prepare("UPDATE posts SET category = ? WHERE category = ?");
        $stmt->bind_param('ss', $defaultCategorySlug, $categorySlugToDelete);
        $stmt->execute();

        // Now, delete the category
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_msg'] = "Category successfully Deleted!";
            header("Location: ../dashboard/category.php");
            exit;
        } else {
            die("Error deleting category");
        }
    } else {
        die("Category not found");
    }
}
?>
