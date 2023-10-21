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
    $adsheader = $_POST['adsheader'];
    $adsslidebar = $_POST['adsslidebar'];
    $adsfooter = $_POST['adsfooter'];
    $adscenter = $_POST['adscenter'];

    // Check if there's an entry with id=1 in the table
    $checkQuery = "SELECT * FROM ads_placement WHERE id=1";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update existing entry
        $query = "UPDATE ads_placement SET adsheader=?, adsslidebar=?, adsfooter=?, adscenter=? WHERE id=1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssss', $adsheader, $adsslidebar, $adsfooter, $adscenter);
    } else {
        // Insert new entry
        $query = "INSERT INTO ads_placement (adsheader, adsslidebar, adsfooter, adscenter) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssss', $adsheader, $adsslidebar, $adsfooter, $adscenter);
    }

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Ads Placement Updated Successfully!";
    } else {
        $_SESSION['error_msg'] = "Error updating ads placement.";
    }

    header("Location: ../dashboard/ads-placement.php");
    exit;
}
?>
