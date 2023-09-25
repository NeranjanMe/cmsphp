<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>FileAJ - Free Software Download</title>
        <link rel="icon" type="image/x-icon" href="include/assets/favicon.ico" />
        <link href="/include/css/styles.css" rel="stylesheet" />

        <style>
            body {
                padding-bottom: 100px; 
            }
        </style>
    </head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $lang == 'en' ? '/' : '/' . $lang . '/'; ?>">Site Name</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo $lang == 'en' ? '/' : '/' . $lang . '/'; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>" href="login">Login</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>" href="register">Register</a></li>
                <!-- Language Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Language
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="/">English (Default)</a></li>
                        <li><a class="dropdown-item" href="/es/">Español</a></li>
                        <li><a class="dropdown-item" href="/ru/">русский</a></li>
                        <li><a class="dropdown-item" href="/fr/">Français</a></li>
                        <li><a class="dropdown-item" href="/it/">Italiano</a></li>
                        <li><a class="dropdown-item" href="/de/">Deutsch</a></li>
                        <li><a class="dropdown-item" href="/mi/">Māori</a></li>
                        <li><a class="dropdown-item" href="/pt/">Portuguese</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header>
    <!-- Add your header content here -->
</header>
