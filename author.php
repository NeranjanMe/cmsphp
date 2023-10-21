<?php
require_once 'database/db_connect.php';
$db = connect_db();

if (!isset($_GET['username']) || empty($_GET['username'])) {
    header("HTTP/1.0 400 Bad Request");
    echo "Invalid request!";
    exit;
}

$username = $_GET['username'];

$stmt = $db->prepare("SELECT posts.*, users.surname AS surname FROM posts JOIN users ON posts.author = users.username WHERE users.username = ? AND status = 'publish' ORDER BY created_at DESC");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);

// Get the author's full name for the page title
$stmtAuthor = $db->prepare("SELECT first_name, surname FROM users WHERE username = ?");
$stmtAuthor->bind_param('s', $username);
$stmtAuthor->execute();
$author = $stmtAuthor->get_result()->fetch_assoc();
$pageTitle = $author['first_name'] . ' ' . $author['surname'];

include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; 
?>

<div class="container mt-5">
    <div class="row g-4 mt-5">
        <div class="col-lg-12">
            <div class="row g-4">
                <h2>Posts by <?php echo $pageTitle; ?></h2>
                <?php if (count($posts) > 0): ?>
                    <?php foreach($posts as $post): ?>
                        <?php 
                        $url = ($post['permalink']);
                        ?>
                        <div class="col-md-6">
                            <div class="card bg-dark text-white position-relative">
                                <img src="uploads/posts/<?php echo $post['image']; ?>" class="card-img" alt="<?php echo $post['title']; ?>">
                                <div class="gradient-overlay"></div>
                                <div class="card-img-overlay d-flex flex-column justify-content-between p-2">
                                    <h4 class="card-overlay-title"><?php echo $post['title']; ?></h4>
                                </div>
                                <a href="<?php echo $url; ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h3><?php echo $pageTitle; ?> hasn't written any posts yet.</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>  
</div>

<?php include 'include/footer.php'; ?>

<!-- Keep the styles you had for the card, it'll work for the author page as well -->

<style>
    .card-overlay-title {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: white;
        padding: 5px 15px;
        border-radius: 5px;
    }

    .card:hover .card-img {
        transform: scale(1.05);
        transition: transform 0.5s;
    }

    .btn-link {
        text-decoration: none;
    }

    .btn-link:hover, .btn-link:focus {
        text-decoration: underline;
    }

    .card {
        overflow: hidden;
    }

    .gradient-overlay {
        background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.9));
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
