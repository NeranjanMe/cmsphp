<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();
$username = $_SESSION['username'];

// Get number of posts created by the user
$stmt = $db->prepare("SELECT COUNT(*) as total_posts FROM posts WHERE author = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_posts = $row['total_posts'];

// Get number of categories
$stmt = $db->prepare("SELECT COUNT(*) as total_categories FROM categories");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_categories = $row['total_categories'];

// Get number of published posts by the user
$stmt = $db->prepare("SELECT COUNT(*) as published_posts FROM posts WHERE author = ? AND status = 'published'");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$published_posts = $row['published_posts'];

// Get number of draft posts by the user
$stmt = $db->prepare("SELECT COUNT(*) as draft_posts FROM posts WHERE author = ? AND status = 'draft'");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$draft_posts = $row['draft_posts'];

include '../include/header.php';
?>

<div class="container">
    <h2>Dashboard</h2>
    <p>Total Posts: <?php echo $total_posts; ?></p>
    <p>Total Categories: <?php echo $total_categories; ?></p>
    <p>Published Posts: <?php echo $published_posts; ?></p>
    <p>Draft Posts: <?php echo $draft_posts; ?></p>
</div>

<?php include '../include/footer.php'; ?>
