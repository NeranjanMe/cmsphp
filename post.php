<?php
require_once 'database/db_connect.php';
$db = connect_db();

if(isset($_GET['permalink'])){
    $permalink = $_GET['permalink'];
} else {
    die("Permalink is missing.");
}

// Fetch language from the URL
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en'; 

$stmt = $db->prepare("SELECT * FROM posts WHERE language = ? AND permalink = ?");
$stmt->bind_param('ss', $lang, $permalink);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

$pageTitle = $post['title'];

$metaTitle = $post['meta_title'];
$metaDescription = $post['meta_description'];
$metaKeyword = $post['meta_keyword'];
$metaAuthor = $post['author'];
$metaLanguage = $post['language'];
$metaImage = "/uploads/posts/" . $post['image'];


if (!$post) {
    include 'include/header.php';
    ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6 text-center">
                <h1 class="mt-4">The "<?php echo htmlspecialchars($permalink); ?>" Post is not available in this language.</h1>
            </div>
        </div>
    </div>
    <?php
    include 'include/footer.php';
    exit;  
}

// Convert the created_at date from the database to a DateTime object
$postDate = new DateTime($post['created_at']);
$currentDate = new DateTime(); // Current date and time

// Calculate the difference between the two dates
$interval = $postDate->diff($currentDate);

// Format the difference
if ($interval->y > 0) {
    $timeAgo = $interval->format('%y Year(s) Ago');
} elseif ($interval->m > 0) {
    $timeAgo = $interval->format('%m Month(s) Ago');
} elseif ($interval->d > 0) {
    $timeAgo = $interval->format('%d Day(s) Ago');
} elseif ($interval->h > 0) {
    $timeAgo = $interval->format('%h Hour(s) Ago');
} elseif ($interval->i > 0) {
    $timeAgo = $interval->format('%i Minute(s) Ago');
} else {
    $timeAgo = 'Just Now';
}


// Get the content from the 'body' column
$content = $post['body'];

// Count the number of words in the content
$wordCount = str_word_count($content);

// Calculate the estimated reading time
$readingTime = ceil($wordCount / 250);


$stmt = $db->prepare("SELECT slug FROM categories WHERE name = ?");
$stmt->bind_param('s', $post['category']);
$stmt->execute();
$categoryResult = $stmt->get_result();
$categoryData = $categoryResult->fetch_assoc();
$categorySlug = $categoryData['slug'];


$adsQuery = "SELECT * FROM ads_placement LIMIT 1";
$adsResult = mysqli_query($db, $adsQuery);
$adsData = mysqli_fetch_assoc($adsResult);


include 'include/header.php';
?>

<div class="container mt-3 d-flex justify-content-center align-items-center">
    <?php echo $adsData['adsheader'] ?? ''; ?>
</div>

<section class="pt-2 mt-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-md-8">
                <div class="card bg-dark-overlay-5 overflow-hidden card-bg-scale text-center" style="height: 400px; background-image:url('uploads/posts/<?php echo $post['image']; ?>'); background-position: center center; background-size: cover;">
                    <div class="bg-dark" style="opacity: 0.6; position: absolute; top: 0; right: 0; bottom: 0; left: 0;"></div>
                    <div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
                        <div class="w-100 my-auto">
                            <h2 class="text-white display-5 fw-bold <?php echo (strlen($post['title']) > 100) ? 'long-title' : ''; ?>">
                                <?php echo $post['title']; ?>
                            </h2>
                            <ul class="nav nav-divider text-white-force align-items-center justify-content-center fw-bold">
                                <li class="nav-item">
                                    <div class="nav-link">
                                        <div class="d-flex align-items-center text-white position-relative fw-bold">
                                            <span class="ms-3">by <a href="author.php?username=<?php echo $post['author']; ?>" class="stretched-link text-reset btn-link fw-bold"><?php echo $post['author']; ?></a></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item fw-bold text-white">|&nbsp;<?php echo $timeAgo; ?></li>
                                <li class="nav-item fw-bold text-white">&nbsp;|&nbsp;<?php echo $readingTime; ?> min read</li>
                            </ul>
                            <a href="/category?category=<?php echo $categorySlug; ?>" class="badge text-bg-danger mb-2 fw-bold"><?php echo htmlspecialchars($post['category']); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<div class="container position-relative mt-4">
    <div class="row">
        <!-- Content -->
        <div class="col-lg-9 mb-5">
            <!-- Audio Player and Download Button START -->
            <?php if (!empty($post['texttovoice'])): ?>
                <div class="mt-4 audio-player-container">
                    <h5 class="audio-header">Listen to this Post:</h5>
                    <audio controls class="w-100 audio-element">
                        <source src="uploads/text-to-voice/<?php echo $post['texttovoice']; ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                    <div class="mt-2">
                        <a href="uploads/text-to-voice/<?php echo $post['texttovoice']; ?>" download>
                            <button class="btn btn-primary">Download Audio</button>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Audio Player and Download Button END -->
        
            <p><?php echo $post['body']; ?></p>
        </div>


        <!-- Right sidebar START -->
        <div class="col-lg-3">
            <!-- Categories -->
            <h5>Categories</h5>
            <?php
            $colors = ['warning', 'info', 'danger', 'primary', 'success'];
            $colorIndex = 0;
            $query = "SELECT categories.name, categories.slug, COUNT(posts.id) as post_count FROM categories LEFT JOIN posts ON categories.name = posts.category GROUP BY categories.name";
            $categories = mysqli_query($db, $query);
            
            while($category = mysqli_fetch_assoc($categories)) {
                // Check if post_count is greater than 0
                if($category['post_count'] > 0) {
                    $color = $colors[$colorIndex % count($colors)];
                ?>
                    <div class="mt-1 d-flex justify-content-between align-items-center bg-<?php echo $color; ?> bg-opacity-10 rounded p-2 position-relative">
                        <h6 class="m-0 text-<?php echo $color; ?>"><?php echo $category['name']; ?></h6>
                        <a href="/category?category=<?php echo $category['slug']; ?>" class="badge bg-<?php echo $color; ?> text-dark stretched-link"><?php echo $category['post_count']; ?></a>
                    </div>
                <?php
                    $colorIndex++;
                }
            }
            ?>
            <div class="mb-4 mt-4">
                <?php echo $adsData['adsslidebar'] ?? ''; ?>
            </div>
        </div>

    </div>
</div>



<?php include 'include/footer.php'; ?>

<style>
    .long-title {
    font-size: 1.5rem;
}
.audio-player-container {
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.audio-player-container:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.audio-header {
    margin-bottom: 15px;
    color: #333;
    font-weight: 600;
}

.audio-element {
    border-radius: 5px;
}
</style>