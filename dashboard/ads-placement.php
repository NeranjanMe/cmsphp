<?php
session_start();

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

$query = "SELECT * FROM ads_placement LIMIT 1";
$result = mysqli_query($db, $query);
$ads = mysqli_fetch_assoc($result);

$pageTitle = "Ads Placement";
include '../include/dashboard_header.php';
include '../include/dashboard_slidenav_head.php';
?>

<h1 class="mt-4">Ads Placement</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Ads Placement</li>
</ol>

<?php
if (isset($_SESSION['error_msg'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error_msg'] . "</div>";
    unset($_SESSION['error_msg']);
}

if (isset($_SESSION['success_msg'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_msg'] . '</div>';
    unset($_SESSION['success_msg']);
}
?>

<div class="card mb-4 mt-5">
    <div class="card-body">
        <form action="../process/process_ads_placement.php" method="post">
            <div class="form-group mt-4">
                <label>ADS Header</label>
                <textarea class="form-control" name="adsheader" rows="5"><?php echo $ads['adsheader'] ?? ''; ?></textarea>

                <label class="mt-3">ADS Slide Bar</label>
                <textarea class="form-control" name="adsslidebar" rows="5"><?php echo $ads['adsslidebar'] ?? ''; ?></textarea>

                <label class="mt-3">ADS Footer</label>
                <textarea class="form-control" name="adsfooter" rows="5"><?php echo $ads['adsfooter'] ?? ''; ?></textarea>

                <label class="mt-3">ADS Center</label>
                <textarea class="form-control" name="adscenter" rows="5"><?php echo $ads['adscenter'] ?? ''; ?></textarea>
            </div>
            <input type="submit" class="btn btn-primary mt-4" value="Update Ads Placement">
        </form>
    </div>
</div>

<?php
include '../include/dashboard_slidenav_down.php';
include '../include/dashboard_footer.php';
?>
