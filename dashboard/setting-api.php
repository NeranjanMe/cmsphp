<?php
session_start();

// Function to fetch settings from the database
function fetch_settings_from_db($db) {
    $query = "SELECT openai, delle2, texttovoice FROM api LIMIT 1";
    $result = $db->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [
        'openai' => '',
        'delle2' => '',
        'texttovoice' => ''
    ];
}

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch settings from the database
$settings = fetch_settings_from_db($db);

$pageTitle = "API Setting";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">API Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">API Settings</li>
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
       

        <form id="public-settings-form" action="../process/process_setting_api.php" method="post">
            <div class="form-group mt-2">
                <label for="openai">Open AI API key</label>
                <div class="input-group">
                    <input type="password" id="openai" name="openai" class="form-control" value="<?php echo htmlspecialchars($settings['openai']); ?>" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="toggleVisibility('openai')">
                            Show Key
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group mt-2">
                <label for="delle2">DELL E-2 API key</label>
                <div class="input-group">
                    <input type="password" id="delle2" name="delle2" class="form-control" value="<?php echo htmlspecialchars($settings['delle2']); ?>" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="toggleVisibility('delle2')">
                            Show Key
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="form-group mt-2">
                <label for="texttovoice">Google Text to Voice API key</label>
                <div class="input-group">
                    <input type="password" id="texttovoice" name="texttovoice" class="form-control" value="<?php echo htmlspecialchars($settings['texttovoice']); ?>" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="toggleVisibility('texttovoice')">
                            Show Key
                        </button>
                    </div>
                </div>
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

function toggleVisibility(inputId) {
    var input = document.getElementById(inputId);
    
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
