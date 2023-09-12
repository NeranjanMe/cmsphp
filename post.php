<?php
require_once 'database/db_connect.php';
$db = connect_db();

if(isset($_GET['permalink'])){
    $permalink = $_GET['permalink'];
} else {
    die("Permalink is missing.");
}

$stmt = $db->prepare("SELECT * FROM posts WHERE permalink = ?");
$stmt->bind_param('s', $permalink);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post not found.");
}

include 'include/header.php';
?>

<header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder"><?php echo $post['title']; ?></h1>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p><?php echo $post['body']; ?></p>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>