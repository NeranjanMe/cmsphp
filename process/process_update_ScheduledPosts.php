<?php
require_once '../database/db_connect.php';
session_start();

// Automatically update the status of posts that are due to be published
$updateStmt = $db->prepare("
    UPDATE posts 
    SET status = 'publish'
    WHERE status = 'schedule' AND scheduled_date <= NOW()
");
$updateStmt->execute();

?>