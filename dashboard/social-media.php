<?php
session_start();

// Function to fetch social media links from the database
function fetch_social_links_from_db($db) {
    $query = "SELECT facebook, twitter, instagram, linkedin, youtube FROM socialmedia LIMIT 1";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'linkedin' => '',
        'youtube' => ''
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

// Fetch social media links from the database
$social_links = fetch_social_links_from_db($db);

$pageTitle = "Social Media Settings";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Social Media Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Social Media Settings</li>
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
        <form id="public-settings-form" action="../process/process_social_media.php" method="post">
                        <div class="form-group mt-2">
                            <label for="facebook">Facebook Profile URL</label>
                            <input type="text" id="facebook" name="facebook" class="form-control" value="<?php echo htmlspecialchars($social_links['facebook']); ?>">
                        </div>
            
                        <div class="form-group mt-2">
                            <label for="twitter">Twitter Profile URL</label>
                            <input type="text" id="twitter" name="twitter" class="form-control" value="<?php echo htmlspecialchars($social_links['twitter']); ?>">
                        </div>
            
                        <div class="form-group mt-2">
                            <label for="instagram">Instagram Profile URL</label>
                            <input type="text" id="instagram" name="instagram" class="form-control" value="<?php echo htmlspecialchars($social_links['instagram']); ?>">
                        </div>
            
                        <div class="form-group mt-2">
                            <label for="linkedin">LinkedIn Profile URL</label>
                            <input type="text" id="linkedin" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($social_links['linkedin']); ?>">
                        </div>
            
                        <div class="form-group mt-2">
                            <label for="youtube">YouTube Channel URL</label>
                            <input type="text" id="youtube" name="youtube" class="form-control" value="<?php echo htmlspecialchars($social_links['youtube']); ?>">
                        </div>
            <input type="submit" value="Save Keys" class="btn btn-primary mt-2">
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
