<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch all categories and their is_default status
$stmt = $db->prepare("SELECT id, name, is_default FROM categories");
$stmt->execute();
$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

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
            

    

<form action="../process/process_setting_category.php" method="post" id="public-settings-form">

    <h2>Select Default Category</h2>
    
    <?php foreach ($categories as $category): ?>
        <label><div class="form-group mt-4">
            <input type="radio" name="default_category" value="<?= $category['id']; ?>" 
                <?= $category['is_default'] ? 'checked' : ''; ?>>
            <?= htmlspecialchars($category['name']); ?></div>
        </label><br>
    <?php endforeach; ?>
    
    <input type="submit" class="btn btn-primary mt-2" value="Set Default Category">
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
<?php include '../include/admin_slidenav_down.php'; ?>
<?php include '../include/admin_footer.php'; ?>

