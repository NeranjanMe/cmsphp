<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$pageTitle = "Content Generation";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Content Generation</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Content Generation</li>
</ol>
<div class="row mt-5">

<h2 class=" mb-4">For Blog</h2>
<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Topic Ideas</h5>
            <p class="card-text">Click the button below to generate a Blog Topic Ideas.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-topic-ideas" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>


<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Outline</h5>
            <p class="card-text">Click the button below to generate a Blog Outline.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-outline" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>


<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Content</h5>
            <p class="card-text">Click the button below to generate a Blog Content.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-content" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Comment Reply</h5>
            <p class="card-text">Click the button below to generate Blog Comment Reply.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-comment-reply" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>

<!-- 2nd Row -->
<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Introduction</h5>
            <p class="card-text">Click the button below to generate a Blog Post Introduction.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-introduction" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>


<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Conclusion</h5>
            <p class="card-text">Click the button below to generate a Blog Post Conclusion.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-conclusion" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>


<div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100 d-flex flex-column">
        <div class="card-body flex-grow-1">
            <h5 class="card-title">Blog Post Title</h5>
            <p class="card-text">Click the button below to generate a Blog Post Title.</p>
        </div>
        <div class="card-footer">
            <a href="generate-blog-title" class="btn btn-primary">
                <i class="fas fa-image"></i> Generate
            </a>
        </div>
    </div>
</div>


</div>


<?php include '../include/dashboard_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});
</script>

<?php include '../include/dashboard_footer.php'; ?>
