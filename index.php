<?php
require_once 'database/db_connect.php';
$db = connect_db();

// Fetch the language from the URL or default to 'en'
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Prepare and execute the query to fetch posts based on language
$stmt = $db->prepare("SELECT * FROM posts WHERE language = ? ORDER BY created_at DESC");
$stmt->bind_param('s', $lang);
$stmt->execute();

$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);
?>

<?php include 'include/header.php'; ?>

<header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">Welcome to Blog Home!</h1>
            <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4">
                <h2><?php echo $post['title']; ?></h2>
                <p><?php echo substr($post['body'], 0, 200); ?><?php if (strlen($post['body']) > 200) echo '...'; ?></p>
                <!-- Updated link to reflect the language subdirectory -->
                <a href="<?php echo "/" . $lang; ?>/post.php?permalink=<?php echo $post['permalink']; ?>" class="btn btn-primary">Read More</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'include/footer.php'; ?>
