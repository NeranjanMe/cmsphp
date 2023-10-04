<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

// Fetch categories from the database for the dropdown
$stmt = $db->prepare("SELECT * FROM categories");
$stmt->execute();
$result = $stmt->get_result();
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Get post details using post ID
$postID = $_GET['id']; // Assuming you're passing the post ID via GET
$stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param('i', $postID); 
$stmt->execute();
$postDetails = $stmt->get_result()->fetch_assoc();

if (!$postDetails) {
    die('Post not found.');
}

$pageTitle = "Edit Post";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    var permalinkEdited = false;

    $(document).ready(function() {
        $('#title').on('input', function() {
            if (!permalinkEdited) {
                var title = $(this).val();
                var slug = createWordpressLikeSlug(title);
                $('#permalink').val(slug);
            }
        });

        $('#permalink').on('input', function() {
            permalinkEdited = true;
        });
    });

    function createWordpressLikeSlug(str) {
        return str
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/&/g, '-and-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
</script>

    <h1 class="mt-4">Edit Post</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Post</li>
    </ol>
    <div class="card mb-4 mt-5">
        <div class="card-body">
            
            <!-- Edit post form -->
            <h2 class="card-title">Edit Post</h2>
            <form action="../process/process_post.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?= htmlspecialchars($postDetails['id']) ?>">
    
            <!-- Title Field -->
            <div class="form-group mt-4">
                <label for="title">Title</label>
                <input type="text" class="form-control mt-2" id="title" name="title" value="<?= htmlspecialchars($postDetails['title']) ?>" required>
            </div>
            
            <!-- Permalink Field -->
            <div class="form-group mt-4">
                <label for="permalink">Permalink</label>
                <input type="text" class="form-control mt-2" id="permalink" name="permalink" value="<?= htmlspecialchars($postDetails['permalink']) ?>" required>
            </div>
    
            <!-- Category Field -->
            <div class="form-group mt-4">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control mt-2" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= $category['name'] === $postDetails['category'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    
            <!-- ... Continue for other form fields ... -->
    
            <!-- Content Body Field -->
            <div class="form-group mt-4">
                <label for="body">Content Body</label>
                <div id="editor"><?= $postDetails['body'] ?></div>
                <textarea id="body" name="body" style="display:none"><?= $postDetails['body'] ?></textarea>
            </div>
    
            <!-- Language Selector for edit-post.php -->
            <div class="form-group mt-4">
                <label for="language">Language</label>
                <select class="form-control mt-2" id="language" name="language" required>
                    <?php 
                    // Define the list of languages for simplicity.
                    $languages = [
                        'en' => 'English (EN)',
                        'es' => 'Spanish (ES)',
                        'fr' => 'French (FR)',
                        'pt' => 'Portuguese (PT)',
                        'nl' => 'Dutch (NL)',
                        'zh' => 'Chinese (ZH)',
                        'de' => 'German (DE)',
                        'ar' => 'Arabic (AR)',
                        'vi' => 'Vietnamese (VI)',
                        'ru' => 'Russian (RU)',
                        'th' => 'Thai (TH)',
                        'pl' => 'Polish (PL)',
                        'tr' => 'Turkish (TR)',
                        'ja' => 'Japanese (JA)',
                        'it' => 'Italian (IT)',
                        'id' => 'Indonesian (ID)',
                        'ko' => 'Korean (KO)',
                    ];
            
                    // Loop through each language and output option, comparing to $postDetails['language'] (assuming your edited post's language is stored in that key).
                    foreach ($languages as $langCode => $langName): 
                    ?>
                        <option value="<?= htmlspecialchars($langCode) ?>" <?= $langCode === $postDetails['language'] ? 'selected' : '' ?>><?= htmlspecialchars($langName) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    
            <!-- Main Keyword -->
            <div class="form-group mt-4">
                <label for="main_keyword">Main Keyword (Only One Keyword)</label>
                <input type="text" class="form-control mt-2" id="main_keyword" name="main_keyword" value="<?= htmlspecialchars($postDetails['mainkeyword']) ?>" required>
            </div>
            
            <!-- Meta Title with Score and Validation for edit-post.php -->
            <div class="form-group mt-4">
                <label for="meta_title">Meta Title <span id="charCount"><?= strlen($postDetails['meta_title']) ?></span>/60</label>
                <textarea class="form-control mt-2" id="meta_title" name="meta_title" rows="2" onkeyup="validateMetaTitle()"><?= htmlspecialchars($postDetails['meta_title']) ?></textarea>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" id="meta_title_score" style="width: <?= $initialScore ?>%;" aria-valuenow="<?= $initialScore ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span id="score_label">Score: <?= $initialScore ?>%</span>
            </div>
            
           
            <!-- Meta Description with Score and Validation for edit-post.php -->
            <div class="form-group mt-4">
                <label for="meta_description">Meta Description <span id="descCharCount"><?= strlen($postDetails['meta_description']) ?></span>/160</label>
                <textarea class="form-control mt-2" id="meta_description" name="meta_description" rows="4" onkeyup="validateMetaDescription()"><?= htmlspecialchars($postDetails['meta_description']) ?></textarea>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" id="meta_description_score" style="width: <?= $initialDescScore ?>%;" aria-valuenow="<?= $initialDescScore ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span id="desc_score_label">Score: <?= $initialDescScore ?>%</span>
            </div>
                         
            <!-- Meta Keyword for edit-post.php -->
            <div class="form-group mt-4">
                <label for="meta_keyword">Meta Keyword</label>
                <textarea class="form-control mt-2" id="meta_keyword" name="meta_keyword" rows="2"><?= htmlspecialchars($postDetails['meta_keyword']) ?></textarea>
            </div>
            
            
            
            <!-- Post Image with Preview for edit-post.php -->
            <div class="form-group mt-4 mb-4">
                <label for="postImage">Post Image</label>
                
                <!-- File Input -->
                <input type="file" class="form-control-file" id="postImage" name="postImage" <?= !empty($postDetails['image']) ? '' : 'required'; ?>>

            
                <!-- Display the current image as a reference -->
                <img id="imagePreview" src="../uploads/posts/<?= $postDetails['image'] ?>" alt="your image" style="<?= empty($postDetails['image']) ? 'display:none;' : 'margin-top: 10px; max-width: 200px;' ?>">
            
                <!-- Inform the user that an image has already been uploaded if applicable -->
                <?php if (!empty($postDetails['image'])): ?>
                    <p class="mt-2">You've already uploaded an image. If you select a new one, it will replace the existing image.</p>
                <?php endif; ?>
            </div>

            
            <!-- Post Status with Scheduled Date for edit-post.php -->
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required onchange="toggleScheduledDate();">
                    <option value="">Select a status</option>
                    <option value="Publish" <?= ($postDetails['status'] === 'Publish') ? 'selected' : '' ?>>Publish</option>
                    <option value="Draft" <?= ($postDetails['status'] === 'Draft') ? 'selected' : '' ?>>Draft</option>
                    <option value="Schedule" <?= ($postDetails['status'] === 'Schedule') ? 'selected' : '' ?>>Schedule</option>
                </select>
            </div>

            
            <div class="form-group" id="scheduledDateContainer" style="<?= ($postDetails['status'] === 'schedule') ? '' : 'display: none;'; ?>">
                <label for="scheduled_date">Scheduled Date (Leave empty for immediate publish):</label>
                <input type="datetime-local" id="scheduled_date" name="scheduled_date" class="form-control" value="<?= $postDetails['scheduled_date'] ?>">
            </div>
                    
                    <button type="submit" class="btn btn-primary mt-4">Update Post</button>
                    </form>
                </div>
            </div>
        
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    var form = document.querySelector('form');
    form.onsubmit = function() {
        var body = document.querySelector('textarea[name=body]');
        body.value = quill.root.innerHTML;
    };
    
    //load Image
    document.getElementById('postImage').addEventListener('change', function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
    
    // Meta Title Score 
    document.getElementById('main_keyword').addEventListener('input', validateMetaTitle);

    function validateMetaTitle() {
        let metaKeywordString = document.getElementById('main_keyword').value;
        let metaKeywords = metaKeywordString.split(',').map(keyword => keyword.trim());
        // Now metaKeywords is an array of individual keywords

        let metaTitle = document.getElementById('meta_title').value;
        let score = 100;

        // Update character count
        document.getElementById('charCount').innerText = metaTitle.length;

        if (metaTitle.length > 60 || metaTitle.length < 50) {
            score -= 50;
        }

        // Check if any keyword is included in the meta title
        let keywordIncluded = metaKeywords.some(keyword => metaTitle.includes(keyword));
        if (!keywordIncluded) {
            score -= 50;
        }

        document.getElementById('meta_title_score').style.width = score + '%';
        document.getElementById('meta_title_score').setAttribute('aria-valuenow', score);

        // Update score label
        document.getElementById('score_label').innerHTML = 'Score: ' + score + '%';
    }
    
    // Script for Meta Description Score
    document.getElementById('main_keyword').addEventListener('input', validateMetaDescription);

    function validateMetaDescription() {
        let metaKeywordString = document.getElementById('main_keyword').value;
        let metaKeywords = metaKeywordString.split(',').map(keyword => keyword.trim());

        let metaDescription = document.getElementById('meta_description').value;
        let score = 100;

        // Update character count
        document.getElementById('descCharCount').innerText = metaDescription.length;

        if (metaDescription.length > 160 || metaDescription.length < 150) {
            score -= 50;
        }

        // Check if any keyword is included in the meta description
        let keywordIncluded = metaKeywords.some(keyword => metaDescription.includes(keyword));
        if (!keywordIncluded) {
            score -= 50;
        }

        document.getElementById('meta_description_score').style.width = score + '%';
        document.getElementById('meta_description_score').setAttribute('aria-valuenow', score);

        // Update score label
        document.getElementById('desc_score_label').innerHTML = 'Score: ' + score + '%';
    }
    
    // You might want to call validateMetaTitle() on page load as well, to immediately get the right score and progress bar width.
    document.addEventListener('DOMContentLoaded', function() {
        validateMetaTitle();
    });
    
    // JavaScript to toggle visibility
    
    function toggleScheduledDate() {
        const statusDropdown = document.getElementById('status');
        const scheduledDateContainer = document.getElementById('scheduledDateContainer');
    
        if (statusDropdown.value === 'schedule') {
            scheduledDateContainer.style.display = 'block';
        } else {
            scheduledDateContainer.style.display = 'none';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        validateMetaDescription();
    });

                     
</script>


<script>
    // Function to preview image after validation
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                // Display the image preview
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                imagePreview.style.marginTop = '10px';
                imagePreview.style.maxWidth = '200px';
            };
            fileReader.readAsDataURL(input.files[0]);
        }
    }

    // Add event listener to the file input field
    document.getElementById('postImage').addEventListener('change', function() {
        previewImage(this);
    });
</script>

<style>
    #editor {
        height: 400px;  /* adjust as needed */
    }
</style>

<div id="editor"></div> 

<?php include '../include/dashboard_slidenav_down.php'; ?>
<?php include '../include/dashboard_footer.php'; ?>
