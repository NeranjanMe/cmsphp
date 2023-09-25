<!DOCTYPE html>
<html lang="<?php echo isset($post['language']) ? $post['language'] : 'en'; ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <!-- Meta tags for SEO and social media -->
        <meta name="title" content="<?php echo $post['meta_title'] ?? ''; ?>" />
        <meta name="description" content="<?php echo $post['meta_description'] ?? ''; ?>" />
        <meta name="keywords" content="<?php echo $post['meta_keyword'] ?? ''; ?>" />
        <meta name="author" content="<?php echo $post['author'] ?? ''; ?>" />
        
        <meta property="og:title" content="<?php echo $post['meta_title'] ?? ''; ?>">
        <meta property="og:site_name" content="Your Site Name"> <!-- Replace 'Your Site Name' -->
        <meta property="og:url" content="Your Current Page URL"> <!-- Use PHP to get the current URL -->
        <meta property="og:description" content="<?php echo $post['meta_description'] ?? ''; ?>">
        <meta property="og:type" content="article"> <!-- Assuming it's an article, adjust if different -->
        <meta property="og:locale" content="<?php echo isset($post['language']) ? $post['language'] : 'en_US'; ?>" />
        <meta property="og:image" content="<?php echo $post['image'] ?? ''; ?>">
        
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@YourTwitterHandle"> <!-- Replace '@YourTwitterHandle' -->
        <meta name="twitter:title" content="<?php echo $post['meta_title'] ?? ''; ?>" />
        <meta name="twitter:description" content="<?php echo $post['meta_description'] ?? ''; ?>" />
        <meta name="twitter:image" content="<?php echo $post['image'] ?? ''; ?>">

        <title> <?php if (isset($post['title'])) { echo $post['title']; } elseif (isset($pageTitle)) { echo $pageTitle; } else { echo 'Default Blog Title'; } ?> </title>
        <link rel="icon" type="image/x-icon" href="/uploads/<?php echo isset($post['image']) ? $post['image'] : 'include/assets/favicon.ico'; ?>" />
        <link href="/include/css/styles.css" rel="stylesheet" />

    </head>
    
<body style="padding-bottom: 100px;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo ($lang == 'en') ? '/' : '/' . $lang . '/'; ?>">Site Name</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="<?php echo ($lang == 'en') ? '/' : '/' . $lang . '/'; ?>">Home</a></li>
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

