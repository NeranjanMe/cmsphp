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

<h1 class="mt-4">New Post</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">New Post</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <!-- New post form -->
        <h2 class="card-title">Add New Post</h2>
        <form action="../process/process_post.php" method="post" enctype="multipart/form-data">

        <div class="form-group mt-4">
            <label for="title">Title</label>
            <input type="text" class="form-control mt-2" id="title" name="title" required>
        </div>
        <div class="form-group mt-4">
            <label for="permalink">Permalink</label>
            <input type="text" class="form-control mt-2" id="permalink" name="permalink" required>
        </div>

            <div class="form-group mt-4">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control mt-2" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            
            <div class="form-group mt-4">
                <label for="body">Content Body</label>
                <div id="editor"></div>
                <textarea id="body" name="body" style="display:none"></textarea>
            </div>

            <div class="form-group mt-4">
                <label for="language">Language</label>
                <select class="form-control mt-2" id="language" name="language" required>
                    <option value="en">English (EN)</option>
                    <option value="es">Spanish (ES)</option>
                    <option value="fr">French (FR)</option>
                    <option value="pt">Portuguese (PT)</option>
                    <option value="nl">Dutch (NL)</option>
                    <option value="zh">Chinese (ZH)</option>
                    <option value="de">German (DE)</option>
                    <option value="ar">Arabic (AR)</option>
                    <option value="vi">Vietnamese (VI)</option>
                    <option value="ru">Russian (RU)</option>
                    <option value="th">Thai (TH)</option>
                    <option value="pl">Polish (PL)</option>
                    <option value="tr">Turkish (TR)</option>
                    <option value="ja">Japanese (JA)</option>
                    <option value="it">Italian (IT)</option>
                    <option value="id">Indonesian (ID)</option>
                    <option value="ko">Korean (KO)</option>
                </select>
            </div>

            <div class="form-group mt-4">
                <label for="main_keyword">Main Keyword (Only One Keyword)</label>
                <input type="text" class="form-control mt-2" id="main_keyword" name="main_keyword" required>
            </div>

            <div class="form-group mt-4">
                <label for="meta_title">Meta Title <span id="charCount">0</span>/60</label>
                <textarea class="form-control mt-2" id="meta_title" name="meta_title" rows="2" onkeyup="validateMetaTitle()"></textarea>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" id="meta_title_score" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span id="score_label">Score: 0%</span> <!-- New span to show the score -->
            </div>

            <!-- Meta Title Score -->
            <script>
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
            </script>


            <div class="form-group mt-4">
                <label for="meta_description">Meta Description <span id="descCharCount">0</span>/160</label>
                <textarea class="form-control mt-2" id="meta_description" name="meta_description" rows="4" onkeyup="validateMetaDescription()"></textarea>
                <div class="progress mt-2">
                    <div class="progress-bar" role="progressbar" id="meta_description_score" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span id="desc_score_label">Score: 0%</span>
            </div>

            <!-- Script for Meta Description Score -->
            <script>
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
            </script>


            <div class="form-group mt-4">
                <label for="meta_keyword">Meta Keyword</label>
                <textarea class="form-control mt-2" id="meta_keyword" name="meta_keyword" rows="2"></textarea>
            </div>
            
            <div class="form-group mt-4">
                <label for="postImage">Post Image</label>
                <input type="file" class="form-control-file" id="postImage" name="postImage">
            </div>

            
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="">Select a status</option>
                    <option value="publish">Publish</option>
                    <option value="draft">Draft</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary mt-4">Create Post</button>
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
        
    </script>

<style>
    #editor {
        height: 400px;  /* adjust as needed */
    }
</style>

<div id="editor"></div> 


<?php include '../include/dashboard_slidenav_down.php'; ?>

<?php include '../include/dashboard_footer.php'; ?>
