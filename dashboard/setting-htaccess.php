<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}
require_once '../database/db_connect.php';
$db = connect_db();

$pageTitle = "htaccess Setting";
include '../include/dashboard_header.php';

$htaccessContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/.htaccess');
?>



<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">htaccess Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">htaccess Settings</li>
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
       
        
        <form a action="../process/process-htaccess.php" method="post">
            
            <div class="form-group mt-4">
                <label for="main_keyword">.htaccess</label>
                <textarea class="form-control mt-2" name="htaccess_content" rows="10" cols="50"><?php echo htmlspecialchars($htaccessContent); ?></textarea>
            </div>
            <input type="submit" class="btn btn-primary mt-4"  value="Update .htaccess">
        </form>

    </div>
</div>


<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
