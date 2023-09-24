<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch settings if needed
// $settings = fetch_settings_from_db($db); 

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

<h1 class="mt-4">Public Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Public Settings</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <form id="public-settings-form">
            <div class="form-group">
                <label for="site_name">Site Name</label>
                <input type="text" id="site_name" name="site_name" class="form-control" value="<?php //echo $settings['site_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tag_line">Tag Line</label>
                <input type="text" id="tag_line" name="tag_line" class="form-control" value="<?php //echo $settings['tag_line']; ?>" required>
            </div>
            <input type="submit" value="Save" class="btn btn-primary mt-2">
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#public-settings-form").submit(function(e){
        e.preventDefault();
        // Perform AJAX request to save settings
        $.ajax({
            url: '../process/save_public_settings.php',
            type: 'post',
            data: {
                site_name: $('#site_name').val(),
                tag_line: $('#tag_line').val()
            },
            success: function(data) {
                alert('Settings saved successfully.');
            },
            error: function() {
                alert('Failed to save settings.');
            }
        });
    });
});
</script>

<?php include '../include/admin_slidenav_down.php'; ?>
<?php include '../include/admin_footer.php'; ?>
