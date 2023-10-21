
<?php
// Start the session
session_start();

// Ensure the user_role session variable is set before using it
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Author';  // defaulting to 'Author' if not set

$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div id="layoutSidenav">
        <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">

                            <div class="sb-sidenav-menu-heading text-white">Core</div>
                            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">Post & Page</div>
                            <a class="nav-link <?php echo ($current_page == 'post.php') ? 'active' : ''; ?>" href="post">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Post Manage
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'page.php') ? 'active' : ''; ?>" href="page">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Page Manage
                            </a>
                            
                            
                            <div class="sb-sidenav-menu-heading text-white">Others</div>
                            <a class="nav-link <?php echo ($current_page == 'category.php') ? 'active' : ''; ?>" href="category">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Category Manage
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'users.php') ? 'active' : ''; ?>" href="users">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Users Manage
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">AI For Generate Content</div>
                           
                            <a class="nav-link <?php echo ($current_page == 'generate-blog-topic-ideas.php') ? 'active' : ''; ?>" href="generate-blog-topic-ideas">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Blog Topic Ideas
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'generate-blog-outline.php') ? 'active' : ''; ?>" href="generate-blog-outline">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Blog Outline
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'generate-blog-content.php') ? 'active' : ''; ?>" href="generate-blog-content">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Blog Content
                            </a>
                            
                            <a class="nav-link <?php echo ($current_page == 'generate.php') ? 'active' : ''; ?>" href="generate">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                More..
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">AI For Generate Image</div>
                            <a class="nav-link" href="generate-image" >
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Generate Image
                            </a>
                            <?php if ($user_role == 'Admin'): ?>
                            <div class="sb-sidenav-menu-heading text-white">SEO</div>
                            <a class="nav-link <?php echo ($current_page == 'search_visibility.php') ? 'active' : ''; ?>" href="search_visibility">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Search Visibility
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'meta-data.php') ? 'active' : ''; ?>" href="meta-data">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Home Meta Data
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">Ads Placement</div>
                            <a class="nav-link <?php echo ($current_page == 'ads-placement.php') ? 'active' : ''; ?>" href="ads-placement">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ads Placement
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">Setting</div>
                            <a class="nav-link <?php echo ($current_page == 'setting-public.php') ? 'active' : ''; ?>" href="setting-public">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Public Setting
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'setting-category.php') ? 'active' : ''; ?>" href="setting-category">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Category Setting
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'setting-api.php') ? 'active' : ''; ?>" href="setting-api">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                API Setting
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'header-footer.php') ? 'active' : ''; ?>" href="header-footer">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Header Footer
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'social-media.php') ? 'active' : ''; ?>" href="social-media">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Social Media
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'setting-robots.php') ? 'active' : ''; ?>" href="setting-robots">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Robots Text Setting
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'setting-htaccess.php') ? 'active' : ''; ?>" href="setting-htaccess">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                htaccess Setting
                            </a>
                            
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">