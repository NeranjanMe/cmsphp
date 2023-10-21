<?php
session_start();

require_once '../database/db_connect.php';
$db = connect_db();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit;
}
if ($_SESSION['user_role'] !== 'Admin') {
    $_SESSION['error_msg'] = "You don't have permission to access this page.";
    header("Location: ../dashboard/index.php");
    exit;
}
// Fetch the current visibility setting from the database
$query = "SELECT search_visibility FROM settings LIMIT 1";
$result = $db->query($query);
$row = $result->fetch_assoc();
$currentVisibility = $row['search_visibility'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visibility = isset($_POST['visibility']) ? 1 : 0;

    // Update the visibility setting in the database
    $query = "UPDATE settings SET search_visibility = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $visibility);
    $stmt->execute();

    header("Location: search_visibility.php?saved=true");
    exit;
}
$pageTitle = "Search Engine Visibility";
include '../include/dashboard_header.php';
include '../include/dashboard_slidenav_head.php';
?>

<h1 class="mt-4">Search Engine Visibility</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Search Visibility</li>
</ol>

<div class="card mb-4 mt-5">
    <div class="card-body">
        <form action="search_visibility.php" method="post">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="visibility" id="visibility" <?php echo $currentVisibility ? 'checked' : ''; ?>>
                <label class="form-check-label" for="visibility">
                    Discourage search engines from indexing this site.
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
        </form>
        <?php
        if (isset($_GET['saved']) && $_GET['saved'] == 'true') {
            echo '<div id="successMessage" class="alert alert-success mt-3">Settings saved successfully!</div>';
        }
        ?>
    </div>
</div>

<?php
include '../include/dashboard_slidenav_down.php';
include '../include/dashboard_footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {  // Ensure the DOM is fully loaded
    // Hide success message after 5 seconds
    if (document.getElementById('successMessage')) {
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 5000);
    }
});
</script>
