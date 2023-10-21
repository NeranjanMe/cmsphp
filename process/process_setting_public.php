<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch POST values
$site_name = isset($_POST['site_name']) ? $_POST['site_name'] : '';
$tag_line = isset($_POST['tag_line']) ? $_POST['tag_line'] : '';
$domain_name = isset($_POST['domain_name']) ? $_POST['domain_name'] : '';

// Validate values
if(empty($site_name) || empty($tag_line) || empty($domain_name)) {
    $_SESSION['error_msg'] = 'All fields are required';
    header("Location: ../dashboard/setting-public.php");
    exit;
}

// Fetch the current logo path from the database
$currentLogoQuery = "SELECT sitelogo FROM settings WHERE id=1"; // Assuming id=1 is the row you want to check
$currentLogoResult = $db->query($currentLogoQuery);
$currentLogoPath = $currentLogoResult->fetch_assoc()['sitelogo'];

// Handle the file upload
$uploadDir = '../uploads/logos/'; // Directory to save uploaded logos. Make sure this directory exists and is writable.
$sitelogoPath = '';

if (isset($_FILES['sitelogo']) && $_FILES['sitelogo']['error'] == 0) {
    // If there's an existing logo, delete it
    if ($currentLogoPath) {
        @unlink($uploadDir . $currentLogoPath); // Adjusted to include the upload directory
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($_FILES['sitelogo']['tmp_name']);
    
    if (in_array($fileType, $allowedTypes) && $_FILES['sitelogo']['size'] <= 2 * 1024 * 1024) { // Check for file type and size (2MB)
        // Get the original uploaded image's name without its extension
        $originalName = pathinfo($_FILES['sitelogo']['name'], PATHINFO_FILENAME);
        
        // Convert the name to a slug format
        $slugName = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($originalName));
        $slugName = trim($slugName, '-'); // Remove any leading or trailing dashes
        
        // Create the filename using the slug, "-logo", and the file extension
        $filename = $slugName . '-logo.' . pathinfo($_FILES['sitelogo']['name'], PATHINFO_EXTENSION);
        
        $destination = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['sitelogo']['tmp_name'], $destination)) {
        $sitelogoPath = $filename;  // Save only the filename, not the full path
            } else {
                $_SESSION['error_msg'] = 'Error uploading the logo. Try again.';
                header("Location: ../dashboard/setting-public.php");
                exit;
            }
    } else {
        $_SESSION['error_msg'] = 'Invalid logo file. Please upload a JPG, JPEG, or PNG file not exceeding 2MB.';
        header("Location: ../dashboard/setting-public.php");
        exit;
    }
}

// Check if settings already exist and decide whether to INSERT or UPDATE
$result = $db->query("SELECT 1 FROM settings");
if($result->num_rows > 0) {
    // If settings exist, update
    if ($sitelogoPath) {
        $stmt = $db->prepare("UPDATE settings SET sitename=?, tagline=?, domain=?, sitelogo=? WHERE id=1");
        $stmt->bind_param('ssss', $site_name, $tag_line, $domain_name, $sitelogoPath);
    } else {
        $stmt = $db->prepare("UPDATE settings SET sitename=?, tagline=?, domain=? WHERE id=1");
        $stmt->bind_param('sss', $site_name, $tag_line, $domain_name);
    }
} else {
    // If settings do not exist, insert
    $stmt = $db->prepare("INSERT INTO settings(sitename, tagline, domain, sitelogo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $site_name, $tag_line, $domain_name, $sitelogoPath);
}

if ($stmt->execute()) {
    $_SESSION['success_msg'] = 'Public Settings saved successfully';
} else {
    $_SESSION['error_msg'] = 'Error saving settings. Try again.';
}

$stmt->close();
$db->close();

// Redirect back to the settings page
header("Location: ../dashboard/setting-public.php");
?>
