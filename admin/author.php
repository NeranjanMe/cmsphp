<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Query to get all authors
$stmt = $db->prepare("SELECT * FROM author");
$stmt->execute();
$result = $stmt->get_result();
$authors = $result->fetch_all(MYSQLI_ASSOC);

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

        <h1 class="mt-4">Authors</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Authors</li>
            </ol>
            <div class="card mb-4 mt-5">
                <div class="card-body">
                    <a href="new-author.php" class="btn btn-primary">Add New Author</a>
                </div>
            </div>


            <!-- Authors table -->
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>SurName</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($authors as $author): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($author['id']) ?></td>
                                        <td><?= htmlspecialchars($author['username']) ?></td>
                                        <td><?= htmlspecialchars($author['first_name']) ?></td>
                                        <td><?= htmlspecialchars($author['last_name']) ?></td>
                                        <td><?= htmlspecialchars($author['email']) ?></td>
                                        <td><?= htmlspecialchars($author['surname']) ?></td>
                                        <td><?= htmlspecialchars($author['created_date']) ?></td>
                                        <td>
                                        <a href="edit-author.php?id=<?= $author['id'] ?>" class="btn btn-info">Edit</a>
                                        <a href="../process/process_author.php?action=delete&id=<?= $author['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">Delete</a>
                                        <a href="reset-author.php?id=<?= $author['id'] ?>" class="btn btn-warning">Reset Password</a>
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
