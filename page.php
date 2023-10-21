<?php
session_start();

require_once 'database/db_connect.php';
$db = connect_db();

if(isset($_GET['slug'])) {
    $page_slug = $_GET['slug'];

    $stmt = $db->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->bind_param("s", $page_slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $page = $result->fetch_assoc();

    if($page) {
        $pageTitle = $page['title'];
        
        $metaTitle = $page['meta_title'];
        $metaDescription = $page['meta_description'];
        $metaKeyword = $page['meta_keyword'];

        $pageContent = $page['content'];
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Page not found!";
        exit;
    }
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Invalid request!";
    exit;
}

include 'include/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <!-- Main Content START -->
        <div class="col-lg-12 mb-5">
            <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
            <div>
                <?php echo $pageContent; ?>
            </div>
        </div>
        <!-- Main Content END -->
    </div>
</div>
        
<?php include 'include/footer.php'; ?>
