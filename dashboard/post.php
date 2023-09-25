<?php
session_start();

require_once '../database/db_connect.php';
$db = connect_db();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

// Get the user's role from the session
$user_role = $_SESSION['user_role'];

// Query to get all posts
$languageFilter = isset($_GET['language']) ? $_GET['language'] : null;

if ($languageFilter) {
    // Only query posts of the selected language
    $stmt = $db->prepare("SELECT * FROM posts WHERE language = ? ORDER BY created_at DESC");
    $stmt->bind_param('s', $languageFilter);
} else {
    // Query all posts if no language filter is set
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY created_at DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);


$pageTitle = "Manage Post";
include '../include/dashboard_header.php';
include '../include/dashboard_slidenav_head.php';
?>

<h1 class="mt-4">Post</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Post</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <a href="new-post.php" class="btn btn-primary">Add New Post</a>
    </div>
</div>

<?php
    if (isset($_SESSION['error_msg'])) {
        echo "<div class='alert alert-danger' id='error_msg'>" . $_SESSION['error_msg'] . "</div>";
        unset($_SESSION['error_msg']);  // remove the message after displaying it
    }

    if (isset($_SESSION['success_msg'])) {
        echo '<div class="alert alert-success" id="success_msg">' . $_SESSION['success_msg'] . '</div>';
        unset($_SESSION['success_msg']); // Remove the message after displaying
    }
?>

<!-- Categories table -->
<div class="card mb-4 mt-5">
    
    

    <div class="card-body">
        <select id="languageFilter" class="form-select mb-2" aria-label="Default select example">
        <option value="" <?= !$languageFilter ? "selected" : "" ?>>All Languages</option>
        <option value="en" <?= $languageFilter === "en" ? "selected" : "" ?>>English (EN)</option>
        <option value="es" <?= $languageFilter === "es" ? "selected" : "" ?>>Spanish (ES)</option>
        <option value="fr" <?= $languageFilter === "fr" ? "selected" : "" ?>>French (FR)</option>
        <option value="pt" <?= $languageFilter === "pt" ? "selected" : "" ?>>Portuguese (PT)</option>
        <option value="nl" <?= $languageFilter === "nl" ? "selected" : "" ?>>Dutch (NL)</option>
        <option value="zh" <?= $languageFilter === "zh" ? "selected" : "" ?>>Chinese (ZH)</option>
        <option value="de" <?= $languageFilter === "de" ? "selected" : "" ?>>German (DE)</option>
        <option value="ar" <?= $languageFilter === "ar" ? "selected" : "" ?>>Arabic (AR)</option>
        <option value="vi" <?= $languageFilter === "vi" ? "selected" : "" ?>>Vietnamese (VI)</option>
        <option value="ru" <?= $languageFilter === "ru" ? "selected" : "" ?>>Russian (RU)</option>
        <option value="th" <?= $languageFilter === "th" ? "selected" : "" ?>>Thai (TH)</option>
        <option value="pl" <?= $languageFilter === "pl" ? "selected" : "" ?>>Polish (PL)</option>
        <option value="tr" <?= $languageFilter === "tr" ? "selected" : "" ?>>Turkish (TR)</option>
        <option value="ja" <?= $languageFilter === "ja" ? "selected" : "" ?>>Japanese (JA)</option>
        <option value="it" <?= $languageFilter === "it" ? "selected" : "" ?>>Italian (IT)</option>
        <option value="id" <?= $languageFilter === "id" ? "selected" : "" ?>>Indonesian (ID)</option>
        <option value="ko" <?= $languageFilter === "ko" ? "selected" : "" ?>>Korean (KO)</option>
    </select>
        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Language</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $currentRefId = null;
                foreach ($posts as $post): 
                        echo "<tr>";
                    
                    // Determine which date to display
                    $displayText = '';
                    $displayDate = '';
                    switch ($post['status']) {
                        case 'publish':
                            $displayText = "Published";
                            $displayDate = $post['created_at'];
                            break;
                        case 'draft':
                            $displayText = "Last Modified";
                            $displayDate = $post['updated_at'];
                            break;
                        case 'schedule':
                            $displayText = "Scheduled";
                            $displayDate = $post['scheduled_date'];
                            break;
                    }
                    
                    $langNames = array(
                        'en' => 'English',
                        'es' => 'Spanish',
                        'fr' => 'French',
                        'pt' => 'Portuguese',
                        'nl' => 'Dutch',
                        'zh' => 'Chinese',
                        'de' => 'German',
                        'ar' => 'Arabic',
                        'vi' => 'Vietnamese',
                        'ru' => 'Russian',
                        'th' => 'Thai',
                        'pl' => 'Polish',
                        'tr' => 'Turkish',
                        'ja' => 'Japanese',
                        'it' => 'Italian',
                        'id' => 'Indonesian',
                        'ko' => 'Korean'
                    );
                ?>
                        <td><?= htmlspecialchars($post['id']) ?></td>
                        <td>
                            <img src="/uploads/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 50px;">
                        </td>
                        <?php echo "<td>" . htmlspecialchars($langNames[$post['language']]) . "</td>"; ?>
                        <td><?= htmlspecialchars($post['title']) ?></td>
                        <td><?= htmlspecialchars($post['author']) ?></td>
                        <td><?= htmlspecialchars($post['category']) ?></td>
                        
                        
                        <td><?= htmlspecialchars($post['status']) ?></td>
                        
                       <?php  // Convert the 24-hour format date to AM/PM format
                        $date = new DateTime($displayDate);
                        $formattedDate = $date->format('Y-m-d h:i:s A');  // This will convert time to AM/PM
                    
                        // Output the displayText and formattedDate in a new table column
                        echo "<td>" . htmlspecialchars($displayText) . "<br>" . htmlspecialchars($formattedDate) . "</td>";
                        ?>
                        
                        
                        
                        <td>
                            <?php 
                                $lang = $post['language'] ?? 'en';
                                $url = ($lang == 'en') ? "/{$post['permalink']}" : "/{$lang}/{$post['permalink']}";  
                            ?>
                            <a href="<?php echo $url; ?>" class="btn btn-primary" target="_blank">View</a>

                            <?php if ($user_role == 'Admin' || ($user_role == 'Author' && $post['author'] == $_SESSION['username'])): ?>
                                <a href="edit-post.php?id=<?= $post['id'] ?>" class="btn btn-info">Edit</a>
                                <a href="../process/process_post.php?action=delete&id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../include/dashboard_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});

document.addEventListener('DOMContentLoaded', function() {  // Ensure the DOM is fully loaded
    // Hide error message after 5 seconds
    if (document.getElementById('error_msg')) {
        setTimeout(function() {
            document.getElementById('error_msg').style.display = 'none';
        }, 5000);
    }

    // Hide success message after 5 seconds
    if (document.getElementById('success_msg')) {
        setTimeout(function() {
            document.getElementById('success_msg').style.display = 'none';
        }, 5000);
    }
});

document.getElementById("languageFilter").addEventListener("change", function() {
        let selectedLanguage = this.value;
        window.location.href = `../dashboard/post.php?language=${selectedLanguage}`;
    });
</script>

<?php include '../include/dashboard_footer.php'; ?>
