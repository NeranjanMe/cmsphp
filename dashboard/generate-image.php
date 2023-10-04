<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$pageTitle = "Generate Image";
include '../include/dashboard_header.php';
?>

<?php include '../include/dashboard_slidenav_head.php'; ?>

<h1 class="mt-4">Generate Image</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Generate Image</li>
</ol>
<div class="card mb-4 mt-5">
    <div class="card-body">
        <label for="keyword"> Enter your keyword(s):</label><br>
        <div class="user-action">
            <input type="text" class="form-control" placeholder="Enter prompt">
            <button class="btn btn-primary mt-2">Get Images</button>
        </div>
    </div>
</div>

<div class="card mb-4 mt-5">
    <div class="card-body">
        <div class="img-container">
            <div class="loader" style="display: none;">Loading...</div>
        </div>
    </div>
</div>

<script>
    const input = document.querySelector('input');
    const button = document.querySelector('button');
    const imgContainer = document.querySelector('.img-container');
    const loader = document.querySelector('.loader'); // Reference to loader

    button.onclick = () => {
        if (input.value) {
            loader.style.display = "block"; // Show loader
            var http = new XMLHttpRequest();
            var data = new FormData();
            data.append('prompt', input.value);

            // Change this line
            http.open('POST', '../generate/generate_image.php', true);

            http.send(data);
            http.onload = () => {
                imgContainer.innerHTML = '';
                var response = JSON.parse(http.response).data;
                response.forEach(e => {
                    var img = document.createElement('img');
                    img.src = 'data:image/jpeg;base64,' + e.b64_json;

                    // Create an anchor tag for download
                    var downloadLink = document.createElement('a');
                    downloadLink.href = img.src; // Set the href to the image source
                    downloadLink.download = 'image.jpg'; // Suggest a default name for the downloaded file
                    downloadLink.appendChild(img); // Append the image to the anchor tag

                    imgContainer.appendChild(downloadLink); // Append the anchor (with the image inside it) to the container
                });
                loader.style.display = "none"; // Hide loader after images are loaded
            }
        }
    }
</script>

<style>
    .loader {
        text-align: center;
        font-size: 24px;
        padding: 50px;
    }
    
    .img-container a {
        display: inline-block;
        position: relative;
        margin: 10px;
        text-decoration: none;
        color: #000;
    }
    
    .img-container a:hover {
        color: #007bff;  /* Change color on hover */
    }
    
    .img-container img {
        display: block;
        max-width: 100%;
    }
    
    .img-container a::after {
        content: "📥";
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 20px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        padding: 5px;
        transition: background-color 0.3s;
    }
    
    .img-container a:hover::after {
        background-color: rgba(255, 255, 255, 0.9);
    }
</style>

<?php include '../include/dashboard_slidenav_down.php'; ?>

<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable();
    });
</script>

<?php include '../include/dashboard_footer.php'; ?>
