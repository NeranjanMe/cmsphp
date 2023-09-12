<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch categories from the database for the dropdown
$stmt = $db->prepare("SELECT * FROM categories");
$stmt->execute();
$result = $stmt->get_result();
$categories = $result->fetch_all(MYSQLI_ASSOC);

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

<h1 class="mt-4">New Post</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">New Post</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <!-- New post form -->
        <h2 class="card-title">Add New Post</h2>
        <form action="../process/process_post.php" method="post">
            <div class="form-group mt-4">
                <label for="title">Title</label>
                <input type="text" class="form-control mt-2" id="title" name="title" required>
            </div>
            <div class="form-group mt-4">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control mt-2" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mt-4">
                <label for="tags">Tags</label>
                <input type="text" class="form-control mt-2" id="tags" name="tags">
            </div>
            
            
            <div class="form-group mt-4">
                <label for="body">Content Body</label>
                <div id="editor"></div>
                <textarea id="body" name="body" style="display:none"></textarea>
            </div>

            <div class="form-group mt-4">
                <label for="language">Language</label>
                <input type="text" class="form-control mt-2" id="language" name="language" required>
            </div>
            <div class="form-group mt-4">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control mt-2" id="meta_title" name="meta_title">
            </div>
            <div class="form-group mt-4">
                <label for="meta_description">Meta Description</label>
                <input type="text" class="form-control mt-2" id="meta_description" name="meta_description">
            </div>
            <div class="form-group mt-4">
                <label for="meta_keyword">Meta Keyword</label>
                <input type="text" class="form-control mt-2" id="meta_keyword" name="meta_keyword">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="">Select a status</option>
                    <option value="publish">Publish</option>
                    <option value="draft">Draft</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary mt-4">Create Post</button>
        </form>
    </div>
</div>



<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var body = document.querySelector('textarea[name=body]');
            body.value = quill.root.innerHTML;
        };
        
    </script>

<style>
    #editor {
        height: 400px;  /* adjust as needed */
    }
</style>

<div id="editor"></div> 


<?php include '../include/admin_slidenav_down.php'; ?>

<?php include '../include/admin_footer.php'; ?>
