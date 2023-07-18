<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Check if the id is present in the URL, fetch the post
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Prepare and execute the SQL statement
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the post
    $post = $result->fetch_assoc();
    if (!$post) {
        die("Post not found.");
    }
} else {
    die("Invalid request.");
}

include '../include/author_header.php';
?>


<?php include '../include/author_slidenav_head.php'; ?>

    <h1 class="mt-4">Edit Post</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Post</li>
    </ol>
    <div class="card mb-4 mt-5">
        <div class="card-body">

        <form action="../process/process_post.php" method="post">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <div class="form-group mt-4">
                <label for="title">Title</label>
                <input type="text" class="form-control mt-2" id="title" name="title" value="<?php echo $post['title']; ?>" required>
            </div>
            <div class="form-group mt-4">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control mt-2" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= $post['category'] === $category['name'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mt-4">
                <label for="tags">Tags</label>
                <input type="text" class="form-control mt-2" id="tags" name="tags" value="<?php echo $post['tags']; ?>">
            </div>
            
            <div class="form-group mt-4">
                <label for="body">Content Body</label>
                <div id="quillEditor" style="height:500px;"></div>
                <textarea id="body" name="body" style="display:none" required><?php echo $post['body']; ?></textarea>
            </div>

            <div class="form-group mt-4">
                <label for="language">Language</label>
                <input type="text" class="form-control mt-2" id="language" name="language" value="<?php echo $post['language']; ?>" required>
            </div>
            <div class="form-group mt-4">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control mt-2" id="meta_title" name="meta_title" value="<?php echo $post['meta_title']; ?>">
            </div>
            <div class="form-group mt-4">
                <label for="meta_description">Meta Description</label>
                <input type="text" class="form-control mt-2" id="meta_description" name="meta_description" value="<?php echo $post['meta_description']; ?>">
            </div>
            <div class="form-group mt-4">
                <label for="meta_keyword">Meta Keyword</label>
                <input type="text" class="form-control mt-2" id="meta_keyword" name="meta_keyword" value="<?php echo $post['meta_keyword']; ?>">
            </div>
            <div class="form-group mt-4">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control mt-2" required>
                    <option value="">Select a status</option>
                    <option value="Published" <?php echo $post['status'] === 'Published' ? 'selected' : '' ?>>Published</option>
                    <option value="Draft" <?php echo $post['status'] === 'Draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Update Post</button>
        </form>

        </div>
    </div>

<?php include '../include/author_slidenav_down.php'; ?>

<script>
var quill = new Quill('#quillEditor', {
    theme: 'snow'
});

quill.on('text-change', function() {
    var delta = quill.getContents();
    var text = quill.getText();
    document.getElementById('body').value = text;
});
</script>


<?php include '../include/author_footer.php'; ?>
