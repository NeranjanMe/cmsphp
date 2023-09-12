<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Check if the id is present in the URL, fetch the author
if (isset($_GET['id'])) {
    $author_id = $_GET['id'];

    // Prepare and execute the SQL statement
    $stmt = $db->prepare("SELECT * FROM author WHERE id = ?");
    $stmt->bind_param('i', $author_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the author
    $author = $result->fetch_assoc();
    if (!$author) {
        die("Author not found.");
    }
} else {
    die("Invalid request.");
}

$updatedDate = new DateTime($author['updated_date']);
$now = new DateTime();

$interval = $now->diff($updatedDate);
$diffInDays = $interval->d;

if ($diffInDays == 0) {
    $timeDiff = "Today";
} elseif ($diffInDays == 1) {
    $timeDiff = "Yesterday";
} else {
    $timeDiff = $diffInDays . " days ago";
}

include '../include/admin_header.php';
?>


<?php include '../include/admin_slidenav_head.php'; ?>

<h1 class="mt-4">Edit Author</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit Author</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">

    <form action="../process/process_author.php?action=update_author&id=<?= $author_id ?>" method="post" onsubmit="return confirm('Are you sure you want to update this author?');">
        <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
        <div class="form-group mt-4">
        <label for="username">Last Updated Date: <?php echo $author['updated_date']; ?> - <?php echo "<label for='username'>($timeDiff)</label><br>"; ?></label><br>
        </div>

        <div class="form-group mt-4">
            <label for="username">Username</label>
            <input type="text" class="form-control mt-2" id="username" name="username" value="<?php echo $author['username']; ?>" readonly>
        </div>

        <div class="form-group mt-4">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control mt-2" id="first_name" name="first_name" value="<?php echo $author['first_name']; ?>" required>
        </div>
        <div class="form-group mt-4">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control mt-2" id="last_name" name="last_name" value="<?php echo $author['last_name']; ?>" required>
        </div>
        <div class="form-group mt-4">
            <label for="last_name">SurName Name</label>
            <input type="text" class="form-control mt-2" id="surname" name="surname" value="<?php echo $author['surname']; ?>" required>
        </div>
        <div class="form-group mt-4">
            <label for="email">Email</label>
            <input type="email" class="form-control mt-2" id="email" name="email" value="<?php echo $author['email']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update Author</button>
    </form>

    </div>
</div>

<?php include '../include/admin_slidenav_down.php'; ?>

<?php include '../include/admin_footer.php'; ?>
