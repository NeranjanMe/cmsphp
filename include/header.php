<?php

require_once 'database/db_connect.php';
$db = connect_db();

// Settings Table
$query = "SELECT * FROM settings LIMIT 1";
$result = mysqli_query($db, $query);
$settings = mysqli_fetch_assoc($result);

$sitelogo = $settings['sitelogo'];
$domain = $settings['domain'];
$sitename = $settings['sitename'];
$currentVisibility = $settings['search_visibility'];

// Posts Table

// Fetch all pages from the database
$pageQuery = "SELECT slug, title FROM pages";
$pageResult = mysqli_query($db, $pageQuery);
$pages = mysqli_fetch_all($pageResult, MYSQLI_ASSOC);


if (!isset($metaImage)) {
    $metaImage = $sitelogo;
}

if (!isset($metaAuthor)) {
    $metaAuthor = $sitename;
}

$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!DOCTYPE html>
<html lang="<?php echo isset($post['language']) ? $post['language'] : 'en'; ?>">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <?php if ($currentVisibility) { echo '<meta name="robots" content="noindex, nofollow">'; } ?>
        
        <link href="/include/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="/uploads/logos/<?php echo $sitelogo; ?>" />
        
        <!-- Add the canonical URL here -->
        <link rel="canonical" href="<?php echo $currentURL; ?>">
        
        <!-- Meta tags for SEO and social media -->
        <meta name="title" content="<?php echo $metaTitle ?? ''; ?>" />
        <meta name="description" content="<?php echo $metaDescription ?? ''; ?>" />
        <meta name="keywords" content="<?php echo $metaKeyword ?? ''; ?>" />
        <meta name="author" content="<?php echo $metaAuthor ?? ''; ?>" />
        
        <meta property="og:title" content="<?php echo $metaTitle ?? ''; ?>">
        <meta property="og:site_name" content="<?php echo $sitename ?? ''; ?>">
        <meta property="og:url" content="<?php echo $currentURL; ?>">
        <meta property="og:description" content="<?php echo $metaDescription ?? ''; ?>">
        <meta property="og:type" content="article">
        <meta property="og:locale" content="<?php echo isset($post['language']) ? $post['language'] : 'en_US'; ?>" />
        <meta property="og:image" content="<?php echo "https://".$domain."/".$metaImage ?? ''; ?>">
        
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@YourTwitterHandle">
        <meta name="twitter:title" content="<?php echo $metaTitle ?? ''; ?>" />
        <meta name="twitter:description" content="<?php echo $metaDescription ?? ''; ?>" />
        <meta name="twitter:image" content="<?php echo "https://".$domain."/".$metaImage ?? ''; ?>">

        <title>
            <?php
            if (!empty($pageTitle)) {
                echo $pageTitle . " - " . $sitename;
            } else {
                echo "Default Page Title - " . $sitename;
            }
            ?>
        </title>

        
        <!-- Schema Markup - Only Post -->
        <?php if (isset($post) && !empty($post)): ?>
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "BlogPosting",
              "headline": "<?php echo $post['title']; ?>",
              "image": [
                "<?php echo "https://".$domain."/".$metaImage; ?>"
               ],
              "author": {
                "@type": "Person",
                "name": "<?php echo $post['author']; ?>"
              },
              "publisher": {
                "@type": "Organization",
                "name": "<?php echo $sitename; ?>",
                "logo": {
                  "@type": "ImageObject",
                  "url": "https://uptoware.com/uploads/logos/<?php echo $sitelogo; ?>"
                }
              },
              "datePublished": "<?php echo isset($post['created_at']) ? date('c', strtotime($post['created_at'])) : ''; ?>",
              "description": "<?php echo $metaDescription ?? ''; ?>"
            }
        </script>
        <?php endif; ?>


    </head>
    
<body style="padding-bottom: 100px;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <?php $homeLink = isset($lang) && $lang != 'en' ? '/' . $lang . '/' : '/'; ?>
        <a class="navbar-brand" href="<?php echo $homeLink; ?>">
            <img src="/uploads/logos/<?php echo $sitelogo; ?>" alt="<?php echo $sitename; ?> Logo" width="30" height="30" class="d-inline-block align-top"> 
            <?php echo $sitename; ?>
        </a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php $homeLink = isset($lang) && $lang != 'en' ? '/' . $lang . '/' : '/'; $isActive = basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>
                <li class="nav-item"><a class="nav-link <?php echo $isActive; ?>" href="<?php echo $homeLink; ?>">Home</a></li>
                <!--<li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>" href="login">Login</a></li>-->
                <!--<li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>" href="register">Register</a></li>-->
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'category.php' ? 'active' : ''; ?>" href="category">Category</a></li>
                <!-- Pages Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <?php foreach ($pages as $page): ?>
                            <li><a class="dropdown-item" href="page?slug=<?php echo htmlspecialchars($page['slug']); ?>"><?php echo htmlspecialchars($page['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

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

