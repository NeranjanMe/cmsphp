<?php
session_start();

require_once '../database/db_connect.php';
$db = connect_db();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

// Query to get all pages
$stmt = $db->prepare("SELECT * FROM pages ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$pages = $result->fetch_all(MYSQLI_ASSOC);

$pageTitle = "Manage Pages";
include '../include/dashboard_header.php';
include '../include/dashboard_slidenav_head.php';
?>

<h1 class="mt-4">Pages</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <a href="new-page.php" class="btn btn-primary">Add New Page</a>
    </div>
</div>

<?php
    if (isset($_SESSION['error_msg'])) {
        echo "<div class='alert alert-danger' id='error_msg'>" . $_SESSION['error_msg'] . "</div>";
        unset($_SESSION['error_msg']);  // remove the message after displaying it
    }

    if (isset($_SESSION['success_msg'])) {
        echo '<div class="alert alert-success" id="success_msg">' . $_SESSION['success_msg'] . '</div>';
        unset($_SESSION['success_msg']); // Remove the message after displaying
    }
?>

<!-- Pages table -->
<div class="card mb-4 mt-5">
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($pages as $page): 
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($page['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($page['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($page['created_at']) . "</td>";
                    echo "<td>";
                    echo "<td>";
                    echo "<a href='../page?slug=" . htmlspecialchars($page['slug']) . "' class='btn btn-primary' target='_blank'>View</a>";
                    
                    // Only show the Edit and Delete buttons for Admins
                    if ($_SESSION['user_role'] === 'Admin') {
                        echo "<a href='edit-page.php?id=" . htmlspecialchars($page['id']) . "' class='btn btn-info'>Edit</a>";
                        echo "<a href='../process/process_page.php?action=delete&id=" . htmlspecialchars($page['id']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this page?\")'>Delete</a>";
                    }
                    echo "</td>";
                    echo "</td>";
                    echo "</tr>";
                endforeach; 
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../include/dashboard_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});

document.addEventListener('DOMContentLoaded', function() {  // Ensure the DOM is fully loaded
    // Hide error message after 5 seconds
    if (document.getElementById('error_msg')) {
        setTimeout(function() {
            document.getElementById('error_msg').style.display = 'none';
        }, 5000);
    }

    // Hide success message after 5 seconds
    if (document.getElementById('success_msg')) {
        setTimeout(function() {
            document.getElementById('success_msg').style.display = 'none';
        }, 5000);
    }
});
</script>

<?php include '../include/dashboard_footer.php'; ?>
