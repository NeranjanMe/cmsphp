<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div id="layoutSidenav">
        <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

                            <div class="sb-sidenav-menu-heading text-white">Core</div>
                            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">Post</div>
                            <a class="nav-link <?php echo ($current_page == 'post.php') ? 'active' : ''; ?>" href="post">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Post Manage
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
                            <a class="nav-link" href="generate-blog-topic-ideas" target="_blank">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Blog Topic Ideas &nbsp;<i class="fas fa-external-link-alt text-white"></i>
                            </a>
                            <a class="nav-link" href="generate-blog-outline" target="_blank">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Blog Outline &nbsp;<i class="fas fa-external-link-alt text-white"></i>
                            </a>
                            <a class="nav-link" href="generate-blog-content" target="_blank">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Blog Content &nbsp;<i class="fas fa-external-link-alt text-white"></i>
                            </a>
                            
                            <div class="sb-sidenav-menu-heading text-white">AI For Generate Image</div>
                            <a class="nav-link" href="generate-image" target="_blank">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Generate Image &nbsp;<i class="fas fa-external-link-alt text-white"></i>
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
                            <a class="nav-link <?php echo ($current_page == 'setting-robots.php') ? 'active' : ''; ?>" href="setting-robots">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Robots Text Setting
                            </a>
                            <a class="nav-link <?php echo ($current_page == 'setting-htaccess.php') ? 'active' : ''; ?>" href="setting-htaccess">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                htaccess Setting
                            </a>
                            
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">