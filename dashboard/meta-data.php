<?php
session_start();
require_once '../database/db_connect.php';
$db = connect_db();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}


// Function to fetch settings from the database
function fetch_meta_data_from_db($db) {
    $query = "SELECT meta_title, meta_keywords, meta_description FROM settings LIMIT 1";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [
        'meta_title' => '',
        'meta_keywords' => '',
        'meta_description' => ''
    ];
}

$meta_data = fetch_meta_data_from_db($db);



$pageTitle = "Home Page Meta Data";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Home Page Meta Data</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Home Page Meta Data</li>
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
       

        <form id="public-settings-form" action="../process/process_meta_data.php" method="post">
            <div class="form-group">
    <label for="meta_title">Meta Title</label>
    <input type="text" id="meta_title" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($meta_data['meta_title'] ?? ''); ?>" required>
</div>

<div class="form-group">
    <label for="meta_keywords">Meta Keywords</label>
    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" value="<?php echo htmlspecialchars($meta_data['meta_keywords'] ?? ''); ?>" required>
</div>

<div class="form-group">
    <label for="meta_description">Meta Description</label>
    <textarea id="meta_description" name="meta_description" class="form-control" rows="3" required><?php echo htmlspecialchars($meta_data['meta_description'] ?? ''); ?></textarea>
</div>

            

            <input type="submit" value="Save" class="btn btn-primary mt-2">
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
