<?php
require_once 'db_connect.php';
$db = connect_db();

$stmt = $db->prepare("SELECT * FROM posts ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4">
                <h2><?php echo $post['title']; ?></h2>
                <p><?php echo $post['content']; ?></p>
                <a href="single_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
