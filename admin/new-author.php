<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

include '../include/admin_header.php';
?>

<?php include '../include/admin_slidenav_head.php'; ?>

<h1 class="mt-4">New Author</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">New Author</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <!-- New author form -->
        <h2 class="card-title">Add New Author</h2>
        <form action="../process/process_author.php" method="post">
            <div class="form-group mt-4">
                <label for="username">Username</label>
                <input type="text" class="form-control mt-2" id="username" name="username" required>
            </div>
            <div class="form-group mt-4">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control mt-2" id="first_name" name="first_name" required>
            </div>
            <div class="form-group mt-4">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control mt-2" id="last_name" name="last_name" required>
            </div>
            <div class="form-group mt-4">
                <label for="email">Email</label>
                <input type="email" class="form-control mt-2" id="email" name="email" required>
            </div>
            <div class="form-group mt-4">
                <label for="surname">Surname</label>
                <input type="text" class="form-control mt-2" id="surname" name="surname">
            </div>
            <div class="form-group mt-4">
                <label for="password">Password</label>
                <input type="password" class="form-control mt-2" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Create Author</button>
        </form>
    </div>
</div>

<?php include '../include/admin_slidenav_down.php'; ?>
<?php include '../include/admin_footer.php'; ?>
