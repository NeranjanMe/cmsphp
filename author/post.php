<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Query to get all posts
$stmt = $db->prepare("SELECT * FROM posts");
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);

include '../include/author_header.php';
?>


<?php include '../include/author_slidenav_head.php'; ?>

        <h1 class="mt-4">Post</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Post</li>
            </ol>
            <div class="card mb-4 mt-5">
                <div class="card-body">
                    <a href="new-post.php" class="btn btn-primary">Add New Post</a>
                </div>
            </div>


            <!-- Categories table -->
                <div class="card mb-4 mt-5">
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Language</th>
                                    <th>Meta Title</th>
                                    <th>Meta Description</th>
                                    <th>Meta Keyword</th>
                                    <th>Status</th>
                                    <th>Author</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($post['title']) ?></td>
                                        <td><?= htmlspecialchars($post['category']) ?></td>
                                        <td><?= htmlspecialchars($post['tags']) ?></td>
                                        <td><?= htmlspecialchars($post['language']) ?></td>
                                        <td><?= htmlspecialchars($post['meta_title']) ?></td>
                                        <td><?= htmlspecialchars($post['meta_description']) ?></td>
                                        <td><?= htmlspecialchars($post['meta_keyword']) ?></td>
                                        <td><?= htmlspecialchars($post['status']) ?></td>
                                        <td><?= htmlspecialchars($post['author']) ?></td>
                                        <td>
                                        <a href="edit-post.php?id=<?= $post['id'] ?>" class="btn btn-info">Edit</a>
                                        <a href="../process/process_post.php?action=delete&id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
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

