<?php
session_start();

// Connect to the database
require_once 'database/db_connect.php';
$db = connect_db();

// Check if an admin already exists
$stmt = $db->prepare("SELECT id FROM users WHERE role = 'admin'");
$stmt->execute();
$adminExists = $stmt->fetch();

if ($adminExists) {
    // Redirect to another page if an admin already exists
    header("Location: login"); // Redirect to login page or any other page you prefer
    exit;
}


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

$current_step = $_SESSION['current_step'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($current_step == 1) {
        // Add your validations for step 1 here
        // If validation passes:
        $_SESSION['step1_data'] = [
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'surname' => $_POST['surname'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];
        $current_step = 2;
        $_SESSION['current_step'] = $current_step;
    }
}

$current_step = isset($_GET['step']) ? (int)$_GET['step'] : ($_SESSION['current_step'] ?? 1);
$_SESSION['current_step'] = $current_step;

$pageTitle = "Register";
include 'include/header.php'; 
?>




<div class="container mt-5">
    <div class="row justify-content-md-center">

        <div class="col-md-3">
            <img src="include/img/register-page-image.png" alt="Description" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2>Register</h2>
            <form action="<?php echo $current_step == 2 ? 'process/process_registration.php' : ''; ?>" method="post" id="registerForm">
            <?php if ($current_step == 1): ?>
                <!-- Step 1 Fields -->
                <div class="form-group mt-3">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control mt-1" id="firstName" placeholder="Enter first name" name="firstName" value="<?php echo htmlspecialchars($input_values['firstName'] ?? ''); ?>" required>
                </div>
                <div class="form-group mt-3">
                    <label for="lastName">Last Name:</label>
                    <input type="text" class="form-control mt-1" id="lastName" placeholder="Enter last name" name="lastName" value="<?php echo htmlspecialchars($input_values['lastName'] ?? ''); ?>" required>
                </div>
                <div class="form-group mt-3">
                    <label for="surname">Surname:</label>
                    <input type="text" class="form-control mt-1" id="surname" placeholder="Enter surname" name="surname" value="<?php echo htmlspecialchars($input_values['surname'] ?? ''); ?>" required>
                </div>

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
                <button type="submit" class="btn btn-primary mt-3">Next</button>
                <?php elseif ($current_step == 2): ?>
                <!-- Step 2 Fields -->

                <!-- Security Questions -->
                <div class="form-group">
                    <label for="security_question1">Security Question 1:</label>
                    <select name="security_question1" class="form-control">
                        <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                        <option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
                        <option value="In what city or town did your mother and father meet?">In what city or town did your mother and father meet?</option>
                    </select>
                    <input type="text" class="form-control" name="security_answer1" placeholder="Your answer" required>
                </div>

                <div class="form-group">
                    <label for="security_question2">Security Question 2:</label>
                    <select name="security_question2" class="form-control">
                        <option value="What was your favorite place to visit as a child?">What was your favorite place to visit as a child?</option>
                        <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                        <option value="What was the name of your elementary school?">What was the name of your elementary school?</option>
                    </select>
                    <input type="text" class="form-control" name="security_answer2" placeholder="Your answer" required>
                </div>

                <div class="form-group">
                    <label for="security_question3">Security Question 3:</label>
                    <select name="security_question3" class="form-control">
                        <option value="What is your grandmother's maiden name?">What is your grandmother's maiden name?</option>
                        <option value="What was the make and model of your first car?">What was the make and model of your first car?</option>
                        <option value="What was the house number and street name you lived in as a child?">What was the house number and street name you lived in as a child?</option>
                    </select>
                    <input type="text" class="form-control" name="security_answer3" placeholder="Your answer" required>
                </div>


                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                <button type="button" class="btn btn-secondary mt-3" onclick="window.location.href='register.php?step=1'">Back</button>
                <?php endif; ?>
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