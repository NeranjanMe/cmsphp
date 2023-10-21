<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Query to get all users
$stmt = $db->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

// Query to get all users with their post counts
$stmt = $db->prepare(" SELECT users.*, SUM(CASE WHEN posts.status = 'publish' THEN 1 ELSE 0 END) as total_posts FROM users LEFT JOIN posts ON users.username = posts.author GROUP BY users.id, users.username ");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);


$pageTitle = "Manage Users";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

        <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <?php if ($_SESSION["user_role"] == "Admin"): ?>
            <div class="card mb-4 mt-5">
                <div class="card-body">
                    
                        <a href="users-new.php" class="btn btn-primary">Add New User</a>
                    
                </div>
            </div>
            <?php endif; ?>

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

            <!-- Users table -->
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>SurName</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Total Posts</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                                        <td><?= htmlspecialchars($user['second_name']) ?></td>
                                        <td><?= htmlspecialchars($user['surname']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['created_date']) ? date('Y-m-d H:i:s', strtotime($user['created_date'])) : 'N/A' ?></td>
                                        <td><?= htmlspecialchars($user['total_posts']) ?></td>
                                        <td>
                                            <?php if ($_SESSION["user_role"] == "Admin"): ?>
                                                <a href="users-edit.php?id=<?= $user['id'] ?>" class="btn btn-info">Edit</a>
                                                <a href="../process/process_user.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                                <a href="users-reset.php?id=<?= $user['id'] ?>" class="btn btn-warning">Reset Password</a>
                                            <?php else: ?>
                                                <p>No actions available</p>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

<?php include '../include/dashboard_slidenav_down.php'; ?>

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

<?php include '../include/dashboard_footer.php'; ?>
