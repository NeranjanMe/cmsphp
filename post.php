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

if (!$post) {
    include 'include/header.php';
    ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6 text-center">
                <h1 class="mt-4">The "<?php echo htmlspecialchars($permalink); ?>" Page is not available in this language.</h1>
            </div>
        </div>
    </div>
    <?php
    include 'include/footer.php';
    exit;  
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
