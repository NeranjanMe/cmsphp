<?php
require_once '../database/db_connect.php';
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

$db = connect_db();

// Check if the id is present in the URL, fetch the user
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute the SQL statement
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the user
    $user = $result->fetch_assoc();
    if (!$user) {
        die("User not found.");
    }
} else {
    die("Invalid request.");
}

$updatedDate = new DateTime($user['created_date']);
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

<h1 class="mt-4">Edit User</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit User</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">

    <form action="../process/process_user.php?action=update_user&id=<?= $user_id ?>" method="post" onsubmit="return confirm('Are you sure you want to update this user?');">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="form-group mt-4">
        <label for="username">Last Updated Date: <?php echo $user['created_date']; ?> - <?php echo "<label for='username'>($timeDiff)</label><br>"; ?></label><br>
        </div>

        <div class="form-group mt-4">
            <label for="username">Username</label>
            <input type="text" class="form-control mt-2" id="username" name="username" value="<?php echo $user['username']; ?>" readonly>
        </div>

        <div class="form-group mt-4">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control mt-2" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>

        <div class="form-group mt-4">
            <label for="second_name">Second Name</label>
            <input type="text" class="form-control mt-2" id="second_name" name="second_name" value="<?php echo htmlspecialchars($user['second_name']); ?>" required>
        </div>

        <div class="form-group mt-4">
            <label for="surname">Surname</label>
            <input type="text" class="form-control mt-2" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required>
        </div>

        <div class="form-group mt-4">
            <label for="email">Email</label>
            <input type="email" class="form-control mt-2" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update User</button>
    </form>

    </div>
</div>

<?php include '../include/admin_slidenav_down.php'; ?>

<?php include '../include/admin_footer.php'; ?>
