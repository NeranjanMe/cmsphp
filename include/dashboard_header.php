<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch sitename and sitelogo from the database
$query = "SELECT sitename, sitelogo FROM settings LIMIT 1";
$result = $db->query($query);
$siteSettings = $result->fetch_assoc();
$sitename = $siteSettings['sitename'];
$sitelogo = $siteSettings['sitelogo'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="robots" content="noindex, nofollow">
        
        <!-- Use sitename in the title -->
        <title><?php echo $pageTitle ?? 'Default Title'; ?> - <?php echo $sitename; ?></title>
        
        <!-- Use sitelogo as the favicon -->
        <?php if ($sitelogo): ?>
            <link rel="icon" href="../uploads/logos/<?php echo htmlspecialchars($sitelogo); ?>" type="image/x-icon">
        <?php endif; ?>
        
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    </head>
    
    <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand using sitename -->
    <a class="navbar-brand ps-3" href="index.html"><?php echo $sitename; ?> - ADMIN</a>

    <!-- Display the username on the right side of the navbar -->
    <div class="ms-auto text-white">
        Welcome, <?php echo $_SESSION['username']; ?>!
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
