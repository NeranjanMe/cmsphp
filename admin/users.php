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

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

        <h1 class="mt-4">Users</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            <div class="card mb-4 mt-5">
                <div class="card-body">
                    <a href="users-new.php" class="btn btn-primary">Add New User</a>
                </div>
            </div>


            <!-- Users table -->
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                                        <td><?= htmlspecialchars($user['second_name']) ?></td>
                                        <td><?= htmlspecialchars($user['surname']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['created_date']) ? date('Y-m-d H:i:s', strtotime($user['created_date'])) : 'N/A' ?></td>
                                        <td><?= htmlspecialchars($user['total_posts']) ?></td>
                                        <td>
                                        <a href="users-edit.php?id=<?= $user['id'] ?>" class="btn btn-info">Edit</a>
                                        <a href="../process/process_user.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                        <a href="users-reset.php?id=<?= $user['id'] ?>" class="btn btn-warning">Reset Password</a>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

<?php include '../include/admin_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});
</script>

<?php include '../include/admin_footer.php'; ?>
