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

$pageTitle = "Robots TXT Setting";
include '../include/dashboard_header.php';

$robotsContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/robots.txt');
?>



<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Robots TXT Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Robots TXT Settings</li>
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
       
        
        <form a action="../process/process-robots.php" method="post">
            
            <div class="form-group mt-4">
                <label for="main_keyword">robots.txt</label>
                <textarea class="form-control mt-2" name="robots_content" rows="10" cols="50"><?php echo htmlspecialchars($robotsContent); ?></textarea>
            </div>
            <input type="submit" class="btn btn-primary mt-4"  value="Update robots.txt">
        </form>

    </div>
</div>


<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
