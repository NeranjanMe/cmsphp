<?php
session_start();

$pageTitle = "Forgot Password";
include 'include/header.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h2>Forgot Password</h2>
            
            <form action="process/process_forgot_password.php" method="post">
                <div class="form-group mt-3">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control mt-1" id="username" placeholder="Enter username" name="username" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>
