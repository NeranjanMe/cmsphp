<?php
session_start();

require_once '../database/db_connect.php';
$db = connect_db();

if (isset($_POST['default_category'])) {
    $chosen_default = $_POST['default_category'];

    // Clear current default
    $stmt = $db->prepare("UPDATE categories SET is_default = 0");
    if (!$stmt->execute()) {
        $_SESSION['error_msg'] = "There was a problem updating the default category.";
        header("Location: ../admin/setting-category.php");
        exit;
    }

    // Set new default
    $stmt = $db->prepare("UPDATE categories SET is_default = 1 WHERE id = ?");
    $stmt->bind_param('i', $chosen_default);
    if (!$stmt->execute() || $stmt->affected_rows <= 0) {
        $_SESSION['error_msg'] = "There was a problem setting the new default category.";
        header("Location: ../admin/setting-category.php");
        exit;
    }

    $_SESSION['success_msg'] = "Default Category Select successfully! ";
    header("Location: ../admin/setting-category.php");
    exit;

} else {
    $_SESSION['error_msg'] = "No category selected.";
    header("Location: ../admin/setting-category.php");
    exit;
}
