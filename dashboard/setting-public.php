<?php
session_start();

// Function to fetch settings from the database
function fetch_settings_from_db($db) {
    $query = "SELECT sitename, tagline, domain, sitelogo FROM settings LIMIT 1";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [
        'sitename' => '',
        'tagline' => '',
        'domain' => '',
        'sitelogo' => ''
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

// Fetch settings from the database
$settings = fetch_settings_from_db($db);

$pageTitle = "Public Setting";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Public Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Public Settings</li>
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
       

        <form id="public-settings-form" action="../process/process_setting_public.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" class="form-control" value="<?php echo htmlspecialchars($settings['sitename']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tag_line">Tag Line</label>
                <input type="text" id="tag_line" name="tag_line" class="form-control" value="<?php echo htmlspecialchars($settings['tagline']); ?>" required>
            </div>
            <div class="form-group">
                <label for="domain_name">Domain Name</label>
                <input type="text" id="domain_name" name="domain_name" class="form-control" value="<?php echo htmlspecialchars($settings['domain']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sitelogo">Site Logo</label>
                <input type="file" id="sitelogo" name="sitelogo" class="form-control">
                <small class="form-text text-muted">Upload a JPG, JPEG, or PNG file. Max size: 2MB.</small>
            </div>

            
            <?php if (!empty($settings['sitelogo'])): ?>
                <div class="mb-4">
                    <img src="../uploads/logos/<?php echo htmlspecialchars($settings['sitelogo']); ?>" alt="Site Logo" style="max-width: 200px;">
                </div>
            <?php endif; ?>

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

document.getElementById('public-settings-form').addEventListener('submit', function(e) {
    var fileInput = document.getElementById('sitelogo');
    var file = fileInput.files[0];
    
    if (file) {
        var fileSize = file.size / 1024 / 1024; // in MB
        var validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        
        if (validTypes.indexOf(file.type) === -1) {
            alert('Please upload a valid image. Only JPG, JPEG, and PNG files are allowed.');
            e.preventDefault();
        } else if (fileSize > 2) {
            alert('The file size should not exceed 2MB.');
            e.preventDefault();
        }
    }
});

</script>

<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
