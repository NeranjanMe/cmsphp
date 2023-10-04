<?php
require_once 'database/db_connect.php';
$db = connect_db();

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

$stmt = $db->prepare("SELECT posts.*, users.surname AS surname 
                      FROM posts 
                      JOIN users ON posts.author = users.username 
                      WHERE language = ? AND status = 'publish' 
                      ORDER BY created_at DESC");
$stmt->bind_param('s', $lang);
$stmt->execute();

$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);


$stmt = $db->prepare("SELECT * FROM categories");
$stmt->execute();
$result_cat = $stmt->get_result();
$categories = $result_cat->fetch_all(MYSQLI_ASSOC);

$default_images = [
    'uploads/posts/apple-imac-m1-review:-the-all-in-one-for-almost-everyone-1695889659.jpg',
    'uploads/posts/businesses-need-community-support-to-stay-afloat-1695889659.jpg',
    'uploads/posts/how-not-to-be-a-character-in-a-‘bad-fashion-movie’-1695889517.jpg',
    'uploads/posts/the-environmental-costs-of-fast-fashion-1695889668.jpg',
    'uploads/posts/why-daily-exposure-to-sunlight-is-good-for-your-health-1695889618.jpg',
    'uploads/posts/woman-walking-on-seaside-while-holding-woven-bag-1695892126.jpg',
];


$pageTitle = "Home";
include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; 
?>
<!-- Custom styles -->
<style>
   /* Your existing style */
    .card-overlay-title {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: white;
        padding: 5px 15px;
        border-radius: 5px;
    }

    /* Zoom-in effect */
    .card:hover .card-img {
        transform: scale(1.05);
        transition: transform 0.5s;
    }

    /* Underline animation for title */
    .title-link::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: white;
        transition: width .3s;
    }
    .title-link:hover::after {
        width: 100%;
    }

    .btn-link {
        text-decoration: none;
    }

    .btn-link:hover, .btn-link:focus {
        text-decoration: underline;
    }

    .card {
        overflow: hidden;  /* This prevents the image from overflowing its container when scaling */
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

<div class="container mt-5">
    <div class="row g-4">
        <!-- Left large card -->
        <?php if (count($posts) > 0): ?>
            <?php 
                function truncate($string, $length, $dots = "...") {
                    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
                }
                ?>
                
                <!-- Original Section for the first post -->
                <?php 
                $post = array_shift($posts);
                $url = ($lang == 'en') ? "/{$post['permalink']}" : "/{$lang}/{$post['permalink']}";
                ?>
                <div class="col-lg-6">
                    <div class="card bg-dark text-white position-relative">
                        <img src="uploads/posts/<?php echo $post['image']; ?>" class="card-img" alt="<?php echo truncate($post['title'], 150); ?>">
                        <div class="gradient-overlay"></div>
                        <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                            <h2 class="card-overlay-title mb-2"><?php echo truncate($post['title'], 150); ?></h2>
                        </div>
                        <a href="<?php echo $url; ?>" class="stretched-link"></a>
                    </div>
                </div>
                
                <!-- Additional Section for the next 4 posts -->
                <div class="col-lg-6">
                    <div class="row g-4">
                        <?php for ($i = 1; $i <= 4 && $i < count($posts); $i++): ?>
                            <?php 
                            $url = ($lang == 'en') ? "/{$posts[$i]['permalink']}" : "/{$lang}/{$posts[$i]['permalink']}";
                            ?>
                            <div class="col-md-6">
                                <div class="card bg-dark text-white position-relative">
                                    <img src="uploads/posts/<?php echo $posts[$i]['image']; ?>" class="card-img" alt="<?php echo truncate($posts[$i]['title'], 150); ?>">
                                    <div class="gradient-overlay"></div>
                                    <div class="card-img-overlay d-flex flex-column justify-content-between p-2">
                                        <h5 class="card-overlay-title"><?php echo truncate($posts[$i]['title'], 100); ?></h5>
                                    </div>
                                    <a href="<?php echo $url; ?>" class="stretched-link"></a>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
        <?php endif; ?>
    </div>  
    
    <!-- Second row starts here -->
    <div class="row g-4 mt-5">
        <!-- Grid of posts -->
        <div class="col-lg-8">
            <div class="row g-4">
                <?php for ($i = 4; $i <= 8 && $i < count($posts); $i++): ?>
                    <?php 
                    $url = ($lang == 'en') ? "/{$posts[$i]['permalink']}" : "/{$lang}/{$posts[$i]['permalink']}";
                    $readTime = ceil(str_word_count($posts[$i]['content']) / 200);
                    ?>
                    <div class="col-md-6">
                        <div class="card bg-dark text-white position-relative">
                            <img src="uploads/posts/<?php echo $posts[$i]['image']; ?>" class="card-img" alt="<?php echo $posts[$i]['title']; ?>">
                            <div class="gradient-overlay"></div>
                            <div class="card-img-overlay d-flex flex-column justify-content-between p-2">
                                <h4 class="card-overlay-title"><?php echo $posts[$i]['title']; ?></h4>
                            </div>
                            <a href="<?php echo $url; ?>" class="stretched-link"></a>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Category List (like a sidebar) -->
        <div class="col-lg-4">
            <?php foreach($categories as $index => $category): ?>
                <!-- Category item -->
                <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-4" 
                     style="background-image:url('uploads/categories/<?php echo $category['image']; ?>'); background-position: center left; background-size: cover;">
                    <div class="bg-dark-overlay-4 p-3">
                        <a href="/category/<?php echo $category['slug']; ?>" class="stretched-link btn-link fw-bold text-white h5"><?php echo $category['name']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        
            <!-- View All Category button -->
            <div class="text-center mt-3">
                <a href="/categories" class="fw-bold text-body text-primary-hover"><u>View all categories</u></a>
            </div>
        </div>

    </div>  
</div>

<?php include 'include/footer.php'; ?>