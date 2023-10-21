<?php
require_once '../database/db_connect.php';
require 'vendor/autoload.php';

use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;

session_start();


// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["username"])){
    header("Location: ../login.php");
    exit;
}

// Connect to the database and store the connection in the variable $db
$db = connect_db();

// Function to generate a URL-friendly slug from a given string
function generateSlug($string) {
    // Convert the string to lowercase
    $slug = strtolower($string);
    
    // Remove characters other than letters, numbers, spaces, and hyphens
    $slug = preg_replace("/[^a-z0-9\s-]/", "", $slug);
    
    // Replace spaces (and possible multiple spaces) with hyphens
    $slug = preg_replace("/[\s]+/", "-", $slug);
    
    return $slug; // Return the generated slug
}

// Function to generate an audio file from the provided content using Google's Text-to-Speech API
function generateAudio($content, $title) {
    // Set the path to the Google Cloud Service Account JSON key for authentication
    putenv('GOOGLE_APPLICATION_CREDENTIALS=service-account.json');

    // Initialize the TextToSpeech client
    $textToSpeechClient = new TextToSpeechClient();

    // Strip any HTML tags from the content
    $inputText = strip_tags($content);
    
    // Prepare the synthesis input with the cleaned text
    $input = new SynthesisInput();
    $input->setText($inputText);

    // Define the voice properties, including language and gender
    $voice = new VoiceSelectionParams([
        'language_code' => 'en-US',
        'ssml_gender' => SsmlVoiceGender::FEMALE
    ]);
    
    // Configure the audio output properties, in this case, MP3 format
    $audioConfig = new AudioConfig([
        'audio_encoding' => AudioEncoding::MP3
    ]);

    // Generate the audio from the given text using the specified configurations
    $response = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);

    // Create a filename for the audio based on the post's title
    $audioFilename = strtolower(str_replace(' ', '-', $title)) . '.mp3';

    // Save the generated audio content to the specified file
    $file = fopen('../uploads/text-to-voice/' . $audioFilename, 'w');
    fwrite($file, $response->getAudioContent());
    fclose($file);

    // Close the TextToSpeech client connection
    $textToSpeechClient->close();

    // Return the generated audio file's name
    return $audioFilename;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch POST data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $body = $_POST['body'];
    $language = $_POST['language'];
    $main_keyword = $_POST['main_keyword'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keyword = $_POST['meta_keyword'];
    $status = $_POST['status'];
    $author = $_SESSION["username"]; 
    $permalink = $_POST['permalink'];
    $filename = ""; // Initialize filename
    $audioPath = generateAudio($body, $title);
    $audioFilename = generateAudio($body, $title);
    
        // Upload Image
        if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] == UPLOAD_ERR_OK) {
            $uploadDirectory = '../uploads/posts/';
            $imageFileType = strtolower(pathinfo($_FILES["postImage"]["name"], PATHINFO_EXTENSION));
            
            $oldImagePath = "../uploads/posts/" . $currentPost['image'];
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
          
            // Use the generateSlug function to convert the title to a slug
            $modifiedTitle = generateSlug($title);
            $uniqueNumber = time(); // Current timestamp for uniqueness
            
            // Create the new filename
            $filename = $modifiedTitle . '-' . $uniqueNumber . '.' . $imageFileType;
            $targetFile = $uploadDirectory . $filename;
            
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["postImage"]["tmp_name"]);
            if($check === false) {
                die("File is not an image.");
            }
        
            // Check file size
            if ($_FILES["postImage"]["size"] > 5000000) { // 5 MB
                die("Sorry, your file is too large.");
            }
        
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }
        
            // Check if file already exists (Though it's highly unlikely due to the unique timestamp)
            if (file_exists($targetFile)) {
                die("Unexpected error: file already exists.");
            }
        
            // Upload file
            if (!move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFile)) {
                die("Sorry, there was an error uploading your file.");
            }
        }
    
    
        if (empty($title) || empty($category) || empty($body) || empty($language) || empty($status) || empty($permalink) || empty($main_keyword)) {
            die("Required fields are empty");
        }

    
        // Retrieve the scheduled date from the form
        $scheduled_date = (isset($_POST['scheduled_date']) && !empty($_POST['scheduled_date'])) ? $_POST['scheduled_date'] : null;
        if ($scheduled_date) {
            $status = "schedule";
        }
    
        // Check if post_id is set for update
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        
        $post_id = $_POST['post_id'];
    // Fetch the current image and audio filenames from the database
    $imgStmt = $db->prepare("SELECT image, texttovoice FROM posts WHERE id = ?");
    $imgStmt->bind_param('i', $post_id);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $currentPost = $imgResult->fetch_assoc();



    // If no new image is uploaded, use the existing filename
    if (empty($filename) && isset($currentPost['image'])) {
        $filename = $currentPost['image'];
    }

    // Delete the old audio file
    $oldAudioPath = '../uploads/text-to-voice/' . $currentPost['texttovoice'];
    if (file_exists($oldAudioPath)) {
        unlink($oldAudioPath);
    }

    // Generate new audio file
    $audioFilename = generateAudio($body, $title);

    // Update post
    $stmt = $db->prepare("UPDATE posts SET title=?, category=?, body=?, meta_title=?, meta_description=?, meta_keyword=?, status=?, author=?, language=?, permalink=?, image=?, scheduled_date=?, mainkeyword=?, texttovoice=? WHERE id=?");
    $stmt->bind_param('ssssssssssssssi', $title, $category, $body, $meta_title, $meta_description, $meta_keyword, $status, $author, $language, $permalink, $filename, $scheduled_date, $main_keyword, $audioFilename, $post_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_msg'] = "Post successfully Updated!";
        header("Location: ../dashboard/post.php"); // Redirect to the posts page
    } else {
        die("Error updating post");
    }
    } else {
        // Insert new post
        $stmt = $db->prepare("INSERT INTO posts (title, category, body, meta_title, meta_description, meta_keyword, status, author, language, permalink, image, scheduled_date, mainkeyword, texttovoice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssssssssss', $title, $category, $body, $meta_title, $meta_description, $meta_keyword, $status, $author, $language, $permalink, $filename, $scheduled_date, $main_keyword, $audioFilename);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_msg'] = "New Post successfully Added!";
            header("Location: ../dashboard/post.php"); // Redirect to the posts page
        } else {
            die("Error adding post");
        }
    }
} 

elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'delete') {
    $id = $_GET['id'];

    if (empty($id)) {
        die("Post ID is required");
    }

    // Step 1: Retrieve the filename of the image and audio associated with the post
    $imgStmt = $db->prepare("SELECT image, texttovoice FROM posts WHERE id = ?");
    $imgStmt->bind_param('i', $id);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $post = $imgResult->fetch_assoc();

    if (!$post || empty($post['image'])) {
        die("No post found with the given ID or post has no associated image.");
    }

    $filename = $post['image'];
    $audioFilename = $post['texttovoice'];

    // Step 2: Delete the post from the database
    $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Step 3: Delete the associated audio file from the server
    $audioPath = '../uploads/text-to-voice/' . $audioFilename;
    if (file_exists($audioPath)) {
        unlink($audioPath);
    }

    if ($stmt->affected_rows > 0) {
        // Step 4: Delete the associated image from the server
        $filePath = "../uploads/posts/" . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $_SESSION['success_msg'] = "Post and its associated image and audio successfully Deleted!";
        header("Location: ../dashboard/post.php"); // Redirect to the posts page
    } else {
        die("Error deleting post");
    }
}

?>