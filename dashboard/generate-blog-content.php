<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

require_once '../database/db_connect.php';
$db = connect_db();

$pageTitle = "Generate Blog Content";
include '../include/dashboard_header.php';
?>


<?php include '../include/dashboard_slidenav_head.php'; ?>

        <h1 class="mt-4">Blog Content</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Blog Content</li>
        </ol>
        <div class="card mb-4 mt-5">
            <div class="card-body">

            <form id="generate-content-form">
                <label for="topic">Enter your blog topic:</label><br>
                <textarea id="topic" name="topic" class="form-control" rows="3" cols="50" required></textarea>

                <input type="submit" value="Generate" class="btn btn-primary mt-2">
            </form>


                
            </div>
        </div>

        <div class="card mb-4 mt-5">
            <div class="card-body">
                <div id="editor" style="height: 300px;"></div>
                <button id="copy-button" class="btn btn-primary mt-2">Copy to Clipboard</button>
                <!-- Spinner -->
                <div id="spinner" style="display: none;">
                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>


        <script>
var quill = new Quill('#editor', {
    theme: 'snow'
});

$(document).ready(function(){
    $("#generate-content-form").submit(function(e){
        e.preventDefault();

        $('#spinner').show();

        $.ajax({
        url: '../generate/generate_blog_content.php',
        type: 'post',
        data: {
            topic: $('#topic').val(),
        },
        success: function(data) {
            var response = JSON.parse(data);
            quill.setContents([
                { insert: response.content }
            ]);
            $('#spinner').hide();
        },
        error: function() {
            alert('Failed to generate content');
            $('#spinner').hide();
        }
        });
    });

    $("#copy-button").click(function(){
        /* Get the text field */
        var copyText = quill.getText();

        /* Copy the text to the clipboard */
        navigator.clipboard.writeText(copyText).then(function() {
            /* Alert the copied text */
            alert("Copied the text: " + copyText);
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    });
});



</script>

<style>


.lds-ring {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 64px;
  height: 64px;
  margin: 8px;
  border: 8px solid #000;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #000 transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
                                

<?php include '../include/dashboard_slidenav_down.php'; ?>

<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable();
});
</script>


<?php include '../include/dashboard_footer.php'; ?>


