<?php 

require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();
$username = $_SESSION['username'];

// Get number of posts created by the user
$stmt = $db->prepare("SELECT COUNT(*) as total_posts FROM posts WHERE author = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_posts = $row['total_posts'];

// Get number of categories
$stmt = $db->prepare("SELECT COUNT(*) as total_categories FROM categories");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_categories = $row['total_categories'];

// Get number of published posts by the user
$stmt = $db->prepare("SELECT COUNT(*) as published_posts FROM posts WHERE author = ? AND status = 'publish'");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$published_posts = $row['published_posts'];

// Get number of draft posts by the user
$stmt = $db->prepare("SELECT COUNT(*) as draft_posts FROM posts WHERE author = ? AND status = 'draft'");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$draft_posts = $row['draft_posts'];

include '../include/author_header.php'; ?>

     <?php include '../include/author_slidenav_head.php'; ?>

                    
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <h1 class="display-4"><?php echo $total_posts; ?></h1>
                                        <i class="fas fa-file-alt fa-3x"></i>
                                        <p>Total Posts</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="post.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <h1 class="display-4"><?php echo $total_categories; ?></h1>
                                        <i class="fas fa-list-alt fa-3x"></i>
                                        <p>Total Categories</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="category.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <h1 class="display-4"><?php echo $published_posts; ?></h1>
                                        <i class="fas fa-check-circle fa-3x"></i>
                                        <p>Published Posts</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <h1 class="display-4"><?php echo $draft_posts; ?></h1>
                                        <i class="fas fa-edit fa-3x"></i>
                                        <p>Draft Posts</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

          <?php include '../include/author_slidenav_down.php'; ?>
<?php include '../include/author_footer.php'; ?>               