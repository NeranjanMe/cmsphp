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

// Initialize $edit_category as null
$edit_category = null;

// Fetch category details for editing
if (isset($_GET['edit_id'])) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param('i', $_GET['edit_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_category = $result->fetch_assoc();
}


include '../include/admin_header.php';
?>


<?php include '../include/admin_slidenav_head.php'; ?>

                    <h1 class="mt-4">Category</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ol>
                        <div class="card mb-4 mt-5">
                            <div class="card-body">

                            <!-- Category form -->
                            <?php if ($edit_category): ?>
                                    <!-- Edit category form -->
                                    <h2 class="card-title">Edit Category</h2>
                                    <form action="../process/process_category.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $edit_category['id']; ?>">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_category['name']; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
                                        <a href="category.php" class="btn btn-primary mt-4">Cancel</a>
                                    </form>
                                <?php else: ?>
                                    <!-- Add new category form -->
                                    <h2 class="card-title">Add New Category</h2>
                                    <form action="../process/process_category.php" method="post">
                                        <div class="form-group">
                                            <label for="name">New Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-4">Add New Category</button>
                                    </form>
                                <?php endif; ?>


                                
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
                                                        <a href="category.php?edit_id=<?php echo $category['id']; ?>" class="btn btn-primary">Edit</a>
                                                        <a href="../process/process_category.php?action=delete&id=<?php echo $category['id']; ?>" class="btn btn-danger">Delete</a>
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


