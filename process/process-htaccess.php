<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

// Check if htaccess content is set
if (isset($_POST['htaccess_content'])) {
    // Get the content from the form
    $content = $_POST['htaccess_content'];

    // Write the content to .htaccess
    if (file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/.htaccess', $content)) {
        $_SESSION['success_msg'] = '.htaccess has been updated successfully!';
    } else {
        $_SESSION['error_msg'] = 'Error updating .htaccess. Please check file permissions.';
    }

    // Redirect back to the settings page
    header("Location: ../dashboard/setting-htaccess.php");
    exit;
}
