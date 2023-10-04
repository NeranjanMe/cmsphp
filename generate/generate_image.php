<?php

require __DIR__ . '/vendor/autoload.php';
include '../database/db_connect.php';  // Include the db connection file

use Orhanerday\OpenAi\OpenAi;

// Use the function to connect to the database
$db = connect_db();

// Fetch the API key for DALL·E from the database (assuming column name is `delle2`)
$sql = "SELECT delle2 FROM api LIMIT 1";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $api_key_delle2 = $row['delle2'];
    }
} else {
    echo json_encode(['error' => 'API key for DALL·E not found in database!']);
    exit;
}

$db->close();

// Initialize OpenAi with the DALL·E API key
$open_ai = new OpenAi($api_key_delle2);

if (isset($_POST['prompt'])) {
    $prompt = $_POST['prompt'];

    try {
        $complete = $open_ai->image([
            "prompt" => $prompt,
            "n" => 3, // number of images
            "size" => "256x256", // image dimension
            "response_format" => "b64_json",// use 'url' for less credit usage
        ]);
        echo $complete;
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No prompt provided']);
}
?>
