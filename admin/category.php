<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$stmt = $db->prepare("SELECT categories.*, COALESCE(COUNT(posts.id), 0) as total_posts FROM categories LEFT JOIN posts ON categories.name = posts.category GROUP BY categories.id");

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

$stmt = $db->prepare("
    SELECT 
        categories.id,
        categories.name,
        COUNT(posts.id) as total_posts 
    FROM 
        categories
    LEFT JOIN 
        posts ON categories.name = posts.category AND posts.status = 'publish'
    GROUP BY 
        categories.id, categories.name
    ORDER BY 
        categories.id DESC
");

$pageTitle = "Manage Categories";
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

                        <!-- Categories table -->
                            <div class="card mb-4 mt-5">
                                <div class="card-body">
                                    <table id="datatablesSimple" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Total Post</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($categories as $category): ?>
                                                <tr>
                                                    <td><?php echo $category['id']; ?></td>
                                                    <td><?php echo $category['name']; ?></td>
                                                    <td><?php echo isset($category['total_posts']) ? $category['total_posts'] : '0'; ?></td>

                                                    
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


<?php include '../include/admin_footer.php'; ?>


