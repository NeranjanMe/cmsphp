<?php
session_start();
include 'include/header.php'; 

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $error_message = '';
}


if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
} else {
    $success_message = '';
}
?>

<div class="container mt-5">
    <div class="row justify-content-md-center">

    <!-- Column for the image on the right -->
        <div class="col-md-3">
            <img src="include/img/login-page-image.png" alt="Description" class="img-fluid ">
        </div>

        <!-- Column for the login form -->
        <div class="col-md-6">
            <h2>Login</h2>

            <?php if($success_message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="process/process_login.php" method="post">
                <div class="form-group mt-3">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control mt-1" id="username" placeholder="Enter username" name="username" required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control mt-1" id="password" placeholder="Enter password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
            <div class="mt-2">
            <a href="forgot_password.php">Forgot password?</a>
            </div>
        </div>
    </div>
</div>


<?php include 'include/footer.php'; ?>
