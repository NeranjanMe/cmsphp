<?php
session_start(); // Move session_start() to the very top
include 'include/header.php'; 

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $error_message = '';
}

$input_values = $_SESSION['input_values'] ?? [];

$usernameValue = $input_values['username'] ?? '';
$emailValue = $input_values['email'] ?? '';

unset($_SESSION['input_values']);

?>
<div class="container mt-5">
    <div class="row justify-content-md-center">

        <!-- Column for the image on the left -->
        <div class="col-md-3">
            <img src="include/img/register-page-image.png" alt="Description" class="img-fluid">
        </div>

        <!-- Column for the register form -->
        <div class="col-md-6">
            <h2>Register</h2>
            <form action="process/process_registration.php" method="post" id="registerForm">
                <div class="form-group mt-3">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control mt-1" id="username" placeholder="Enter username" name="username" value="<?php echo htmlspecialchars($usernameValue); ?>" required>
                    <span class="text-danger"><?php echo $error_message; ?></span>
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control mt-1" id="email" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password: <small>(e.g., Abc@1234)</small></label>
                    <input type="password" class="form-control mt-1" id="password" placeholder="Enter password" name="password" required>
                </div>
                <div class="form-group mt-3">
                    <label for="rePassword">Re-enter Password:</label>
                    <input type="password" class="form-control mt-1" id="rePassword" placeholder="Re-enter password" name="rePassword" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('registerForm');
    const passwordField = document.getElementById('password');
    const rePasswordField = document.getElementById('rePassword');
    const emailField = document.getElementById('email');
    const usernameField = document.getElementById('username');

    //Invalid Email Check
    emailField.addEventListener('input', () => {
        if (emailField.validity.typeMismatch) {
            emailField.classList.add('is-invalid');
        } else {
            emailField.classList.remove('is-invalid');
        }
    });

    //validate Password Complexity
    function validatePasswordComplexity(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/;
    return regex.test(password);
      }

      passwordField.addEventListener('input', () => {
          if (!validatePasswordComplexity(passwordField.value)) {
              passwordField.setCustomValidity('Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
              passwordField.classList.add('is-invalid');
          } else {
              passwordField.setCustomValidity('');
              passwordField.classList.remove('is-invalid');
          }
          validatePasswords();
      });

    //Re Enter Password Check
    function validatePasswords() {
        if (passwordField.value !== rePasswordField.value) {
            rePasswordField.setCustomValidity('Passwords do not match');
            rePasswordField.classList.add('is-invalid');
        } else {
            rePasswordField.setCustomValidity('');
            rePasswordField.classList.remove('is-invalid');
        }
    }

    passwordField.addEventListener('input', validatePasswords);
    rePasswordField.addEventListener('input', validatePasswords);

    form.addEventListener('submit', (e) => {
        validatePasswords();
        if (!form.checkValidity()) {
            e.preventDefault();
        }
    });
</script>



<?php include 'include/footer.php'; ?>