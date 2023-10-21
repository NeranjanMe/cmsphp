<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$pageTitle = "Add New Page";
include '../include/dashboard_header.php';
include '../include/dashboard_slidenav_head.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    var permalinkEdited = false;

    $(document).ready(function() {
        $('#title').on('input', function() {
            if (!permalinkEdited) {
                var title = $(this).val();
                var slug = createWordpressLikeSlug(title);
                $('#slug').val(slug);
            }
        });

        $('#slug').on('input', function() {
            permalinkEdited = true;
        });
    });

    function createWordpressLikeSlug(str) {
        return str
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/&/g, '-and-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
</script>

<h1 class="mt-4">New Page</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">New Page</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <!-- New page form -->
        <h2 class="card-title">Add New Page</h2>
        <form action="../process/process_page.php" method="post">

            <div class="form-group mt-4">
                <label for="title">Title</label>
                <input type="text" class="form-control mt-2" id="title" name="title" required>
            </div>
            <div class="form-group mt-4">
                <label for="slug">Slug (Permalink)</label>
                <input type="text" class="form-control mt-2" id="slug" name="slug" required>
            </div>

            <div class="form-group mt-4">
                <label for="content">Content Body</label>
                <div id="editor"></div>
                <textarea id="content" name="content" style="display:none"></textarea>
            </div>
            
            <!-- Meta Title -->
<div class="form-group mt-4">
    <label for="meta_title">Meta Title</label>
    <input type="text" class="form-control mt-2" id="meta_title" name="meta_title">
</div>

<!-- Meta Keyword -->
<div class="form-group mt-4">
    <label for="meta_keyword">Meta Keyword</label>
    <input type="text" class="form-control mt-2" id="meta_keyword" name="meta_keyword">
</div>

<!-- Meta Description -->
<div class="form-group mt-4">
    <label for="meta_description">Meta Description</label>
    <textarea class="form-control mt-2" id="meta_description" name="meta_description" rows="3"></textarea>
</div>

            <button type="submit" class="btn btn-primary mt-4">Create Page</button>
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
        var content = document.querySelector('textarea[name=content]');
        content.value = quill.root.innerHTML;
    };
</script>

<style>
    #editor {
        height: 400px;  /* adjust as needed */
    }
</style>

<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
