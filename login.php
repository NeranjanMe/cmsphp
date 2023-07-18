<?php include 'include/header.php'; ?>

  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <h2>Login</h2>
        <form action="process/process_login.php" method="post">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

<?php include 'include/footer.php'; ?>
