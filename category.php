<?php
require_once 'database/db_connect.php';
$db = connect_db();

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$category_slug = isset($_GET['category']) ? $_GET['category'] : '';

if ($category_slug) {
    // Fetch posts based on category slug
    $stmt = $db->prepare("SELECT posts.*, users.surname AS surname, categories.slug FROM posts JOIN users ON posts.author = users.username JOIN categories ON posts.category = categories.name WHERE language = ? AND status = 'publish' AND categories.slug = ? ORDER BY created_at DESC");
    $stmt->bind_param('ss', $lang, $category_slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    
    // Fetch the category name based on the slug
    $stmtCategory = $db->prepare("SELECT name,description,image FROM categories WHERE slug = ?");
    $stmtCategory->bind_param('s', $category_slug);
    $stmtCategory->execute();
    $categoryResult = $stmtCategory->get_result();
    $categoryData = $categoryResult->fetch_assoc();
    
    if ($categoryData) {
        $pageTitle = ucfirst($categoryData['name']);
        $metaTitle = ucfirst($categoryData['name']);
        $metaDescription = ucfirst($categoryData['description']);
        $metaImage = "uploads/categories/" . $categoryData['image'];
    } else {
        $pageTitle = ucfirst($category_slug);
    }
    
} else {
    $stmt = $db->prepare("SELECT * FROM categories");
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $pageTitle = "Categories";
}

include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; 
?>

<div class="container mt-5">
    <div class="row g-4 mt-5">
        <div class="col-lg-12">
            <div class="row g-4">
                <?php if ($category_slug): ?>
                    <?php if (count($posts) > 0): ?>
                        <?php foreach($posts as $post): ?>
                            <?php 
                            $url = ($lang == 'en') ? "/{$post['permalink']}" : "/{$lang}/{$post['permalink']}";
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
                        <h2>No posts in this category.</h2>
                    <?php endif; ?>
                <?php else: ?>
                    <?php foreach($categories as $category): ?>
                        <div class="col-md-4">
    <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded" 
         style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('uploads/categories/<?php echo $category['image']; ?>'); background-position: center left; background-size: cover;">
        <div class="p-3">
            <a href="category.php?category=<?php echo $category['slug']; ?>" class="stretched-link btn-link fw-bold text-white h5"><?php echo $category['name']; ?></a>
        </div>
    </div>
</div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>  
</div>

<?php include 'include/footer.php'; ?>

<!-- Custom styles -->
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
