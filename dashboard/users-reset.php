<?php
require_once '../database/db_connect.php';
session_start();

if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}
if ($_SESSION['user_role'] !== 'Admin') {
    $_SESSION['error_msg'] = "You don't have permission to access this page.";
    header("Location: ../dashboard/index.php");
    exit;
}
$db = connect_db();

if (isset($_GET['id'])) {
    $author_id = $_GET['id'];
} else {
    die("Invalid request.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt = $db->prepare("UPDATE author SET password = ? WHERE id = ?");
    $stmt->bind_param('si', $password_hash, $author_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Password reset successfully.";
    } else {
        echo "Error resetting password.";
    }
}

$pageTitle = "Reset Password User";
include '../include/dashboard_header.php';
?>
<?php include '../include/dashboard_slidenav_head.php'; ?>
    <h1 class="mt-4">Reset Password User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Reset Password User</li>
    </ol>
    <div class="card mb-4 mt-5">
        <div class="card-body">
            <form action="../process/process_user.php?action=reset_password&id=<?= $author_id ?>" method="post" onsubmit="Reset Password?">
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control mt-2" id="new_password" name="new_password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" class="form-control mt-2" id="confirm_password" name="confirm_password" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    <?php include '../include/dashboard_slidenav_down.php'; ?>

<?php include '../include/dashboard_footer.php'; ?>
