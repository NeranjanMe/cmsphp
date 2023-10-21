<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Reset Password";
include 'include/header.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <h2>Reset Password</h2>
            
            <form action="process/process_reset_password.php" method="post" id="resetPasswordForm">
                <div class="form-group mt-3">
                    <label for="new_password">New Password: <small>(e.g., Abc@1234)</small></label>
                    <input type="password" class="form-control mt-1" id="new_password" name="new_password" required>
                </div>
                <div class="form-group mt-3">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" class="form-control mt-1" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('resetPasswordForm');
    const newPasswordField = document.getElementById('new_password');
    const confirmPasswordField = document.getElementById('confirm_password');

    // validate Password Complexity
    function validatePasswordComplexity(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/;
        return regex.test(password);
    }

    newPasswordField.addEventListener('input', () => {
        if (!validatePasswordComplexity(newPasswordField.value)) {
            newPasswordField.setCustomValidity('Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
            newPasswordField.classList.add('is-invalid');
        } else {
            newPasswordField.setCustomValidity('');
            newPasswordField.classList.remove('is-invalid');
        }
        validatePasswords();
    });

    // Re Enter Password Check
    function validatePasswords() {
        if (newPasswordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Passwords do not match');
            confirmPasswordField.classList.add('is-invalid');
        } else {
            confirmPasswordField.setCustomValidity('');
            confirmPasswordField.classList.remove('is-invalid');
        }
    }

    newPasswordField.addEventListener('input', validatePasswords);
    confirmPasswordField.addEventListener('input', validatePasswords);

    form.addEventListener('submit', (e) => {
        validatePasswords();
        if (!form.checkValidity()) {
            e.preventDefault();
        }
    });
</script>

<?php include 'include/footer.php'; ?>
