<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $headerContent = $_POST['header'];
    $footerContent = $_POST['footer'];

    // Check if there's an entry with id=1 in the table
    $checkQuery = "SELECT * FROM headerfooter WHERE id=1";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update existing entry
        $query = "UPDATE headerfooter SET header=?, footer=? WHERE id=1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $headerContent, $footerContent);
    } else {
        // Insert new entry
        $query = "INSERT INTO headerfooter (header, footer) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $headerContent, $footerContent);
    }

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Header and Footer Updated Successfully!";
    } else {
        $_SESSION['error_msg'] = "Error updating header and footer.";
    }

    header("Location: ../dashboard/header-footer.php");
    exit;
}
?>
