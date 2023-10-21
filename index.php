<?php
// Import the database connection file
require_once 'database/db_connect.php';
// Establish a database connection
$db = connect_db();

// Get the selected language from URL parameters or set the default to 'en'
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Prepare the SQL query to fetch posts in the given language that are published, and also join with the users table to get the author's surname
$stmt = $db->prepare("SELECT posts.*, users.surname AS surname FROM posts JOIN users ON posts.author = users.username WHERE language = ? AND status = 'publish' ORDER BY created_at DESC");
$stmt->bind_param('s', $lang);
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);

// Prepare the SQL query to fetch all categories
$stmt = $db->prepare("SELECT * FROM categories");
$stmt->execute();
$result_cat = $stmt->get_result();
$categories = $result_cat->fetch_all(MYSQLI_ASSOC);

// Fetch site settings from the database
$query = "SELECT * FROM settings LIMIT 1";
$result = mysqli_query($db, $query);
$settings = mysqli_fetch_assoc($result);

// Assign meta details from the settings
$home_meta_title = $settings['meta_title'];
$metaTitle = $settings['meta_title'];
$metaDescription = $settings['meta_description'];
$metaKeyword = $settings['meta_keyword'];

// Set the page title
$pageTitle = $home_meta_title;
// Include the website header
include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php'; 
?>


<div class="container mt-5">
   <div class="row g-4">
    <!-- Left large card -->
    <?php if (count($posts) > 0): 
            function truncate($string, $length, $dots = "...") {
                return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
            }
        ?>
        <!-- Section for the first 2 posts in the first col-lg-6 -->
        <div class="col-lg-6">
            <div class="row g-4">
                <?php for ($i = 0; $i < 2 && $i < count($posts); $i++):
                    $url = ($lang == 'en') ? "/{$posts[$i]['permalink']}" : "/{$lang}/{$posts[$i]['permalink']}";
                    ?>
                    <div class="col-md-12">
                        <div class="card bg-dark text-white position-relative">
                            <img src="uploads/posts/<?php echo $posts[$i]['image']; ?>" class="card-img" alt="<?php echo truncate($posts[$i]['title'], 150); ?>">
                            <div class="gradient-overlay"></div>
                            <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                <h2 class="card-overlay-title mb-2"><?php echo truncate($posts[$i]['title'], 150); ?></h2>
                            </div>
                            <a href="<?php echo $url; ?>" class="stretched-link"></a>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        
        <!-- Additional Section for the next 4 posts in the second col-lg-6 -->
        <div class="col-lg-6">
            <div class="row g-4">
                <?php for ($i = 2; $i < 6 && $i < count($posts); $i++):
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
                <?php for ($i = 6; $i < 11 && $i < count($posts); $i++): 
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
                <div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-4" 
                     style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/uploads/categories/<?php echo $category['image']; ?>'); background-position: center left; background-size: cover;">
                    <div class="bg-dark-overlay-4 p-3">
                        <a href="/category?category=<?php echo $category['slug']; ?>" class="stretched-link btn-link fw-bold text-white h5"><?php echo $category['name']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="text-center mt-3">
                <a href="/category" class="fw-bold text-body text-primary-hover"><u>View all categories</u></a>
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

/* Zoom-in effect */
.card:hover .card-img {
    transform: scale(1.05);
    transition: transform 0.5s;
}

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
    overflow: hidden; 
    height: 250px;
}

.card-img {
    object-fit: cover;
    height: 100%;
    width: 100%; 
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