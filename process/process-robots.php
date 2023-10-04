<?php
session_start();
// Check if robots content is set
if (isset($_POST['robots_content'])) {
    // Get the content from the form
    $content = $_POST['robots_content'];

    // Write the content to robots.txt
    if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/robots.txt', $content)) {
        $_SESSION['success_msg'] = 'robots.txt has been updated successfully!';
    } else {
        $_SESSION['error_msg'] = 'Error updating robots.txt. Please check file permissions.';
    }

    // Redirect back to the settings page
    header("Location: ../dashboard/setting-robots.php");
    exit;
}
?>