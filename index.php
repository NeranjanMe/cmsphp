<?php
require_once 'database/db_connect.php';
$db = connect_db();

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

$stmt = $db->prepare("SELECT * FROM posts WHERE language = ? AND status = 'publish' ORDER BY created_at DESC");
$stmt->bind_param('s', $lang);
$stmt->execute();

$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);

$pageTitle = "Home";
include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; 
?>

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

            <div class="col-md-2 mb-4">
                <div class="card h-100 text-center">

                    <img src="uploads/<?php echo $post['image']; ?>" class="card-img-top mt-3" alt="<?php echo $post['title']; ?>" style="width: 60%; margin: auto;">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                    </div>

                    <?php $url = ($lang == 'en') ? "/{$post['permalink']}" : "/{$lang}/{$post['permalink']}";  ?>
                    <div class="card-footer">
                        <a href="<?php echo $url; ?>" class="btn btn-primary btn-sm">Download</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php include 'include/footer.php'; ?>
