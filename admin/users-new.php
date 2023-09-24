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

<h1 class="mt-4">New User</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">New User</li>
</ol>

<div class="card mb-4 mt-5">
    <div class="card-body">

        <!-- Display error message if any -->
        <?php
        if (isset($_SESSION['error_msg'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['error_msg'] . "</div>";
            unset($_SESSION['error_msg']); // Remove the message after displaying it
        }
        ?>
        
        <!-- New User form -->
        <h2 class="card-title">Add New User</h2>
        <form action="../process/process_user.php?action=add_new_user" method="post">
            <div class="form-group mt-4">
                <label for="role">Role</label>
                <select class="form-control mt-2" id="role" name="role">
                    <option value="Author">Author</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="username">Username</label>
                <input type="text" class="form-control mt-2" id="username" name="username" required>
            </div>

            <div class="form-group mt-4">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control mt-2" id="first_name" name="first_name" required>
            </div>

            <div class="form-group mt-4">
                <label for="second_name">Last Name</label>
                <input type="text" class="form-control mt-2" id="second_name" name="second_name" required>
            </div>

            <div class="form-group mt-4">
                <label for="surname">Surname</label>
                <input type="text" class="form-control mt-2" id="surname" name="surname">
            </div>

            <div class="form-group mt-4">
                <label for="email">Email</label>
                <input type="email" class="form-control mt-2" id="email" name="email" onkeyup="validateEmail()" required>
                <small id="emailError" class="form-text text-danger" style="display: none;">Invalid email format.</small>
            </div>
            
            <div class="form-group mt-4">
                <label for="password">Password</label>
                <input type="password" class="form-control mt-2" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Create User</button>
        </form>
    </div>
</div>

<script>
    function validateEmail() {
        var emailInput = document.getElementById('email');
        var emailError = document.getElementById('emailError');

        // Regular expression for validating email
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailRegex.test(emailInput.value)) {
            // If email format is invalid
            emailInput.style.borderColor = "red";
            emailError.style.display = "block";
        } else {
            // If email format is valid
            emailInput.style.borderColor = "";
            emailError.style.display = "none";
        }
    }
</script>

<?php include '../include/admin_slidenav_down.php'; ?>
<?php include '../include/admin_footer.php'; ?>
