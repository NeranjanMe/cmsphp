<?php
session_start();

// Function to fetch header and footer content from the database
function fetch_header_footer_from_db($db) {
    $query = "SELECT header, footer FROM headerfooter LIMIT 1";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [
        'header' => '',
        'footer' => ''
    ];
}

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}
if ($_SESSION['user_role'] !== 'Admin') {
    $_SESSION['error_msg'] = "You don't have permission to access this page.";
    header("Location: ../dashboard/index.php");
    exit;
}
require_once '../database/db_connect.php';
$db = connect_db();

// Fetch header and footer content from the database
$header_footer = fetch_header_footer_from_db($db);

$pageTitle = "Header & Footer Settings";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Header & Footer Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Header & Footer Settings</li>
</ol>

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

<div class="card mb-4 mt-5">
    <div class="card-body">
        <form id="header-footer-form" action="../process/process_header_footer.php" method="post">
            <div class="form-group mt-2">
                <label for="header">Header Content</label>
                <textarea id="header" name="header" class="form-control" rows="5"><?php echo htmlspecialchars($header_footer['header']); ?></textarea>
            </div>
            
            <div class="form-group mt-2">
                <label for="footer">Footer Content</label>
                <textarea id="footer" name="footer" class="form-control" rows="5"><?php echo htmlspecialchars($header_footer['footer']); ?></textarea>
            </div>
            
            <input type="submit" value="Save Content" class="btn btn-primary mt-2">
        </form>
    </div>
</div>

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

<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
