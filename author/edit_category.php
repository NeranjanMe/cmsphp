<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$stmt = $db->prepare("SELECT * FROM categories ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Get the category details
$stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

include '../include/author_header.php';
?>


<?php include '../include/author_slidenav_head.php'; ?>

                    <h1 class="mt-4">Category</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <!-- Add new category form -->
                                <form action="../process/process_category.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>

                        <!-- Categories table -->
                            <div class="card mb-4 mt-5">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Categories Table
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?php echo $category['id']; ?></td>
                                                    <td><?php echo $category['name']; ?></td>
                                                    <td>
                                                        <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-primary">Edit</a>
                                                        <a href="../process/process_category.php?action=delete&id=<?php echo $category['id']; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

<?php include '../include/author_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});
</script>


<?php include '../include/author_footer.php'; ?>


