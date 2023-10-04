<?php

include '../database/db_connect.php';  // Include the db connection file

// Use the function to connect to the database
$db = connect_db();

// Fetch the API key from the database
$sql = "SELECT openai FROM api LIMIT 1";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $api_key = $row['openai'];
    }
} else {
    echo "API key not found in database!";
    exit;
}

$db->close();

$keyword = $_POST['keyword'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/engines/text-davinci-002/completions');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer ' . $api_key;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = json_encode([
    'prompt' => "Give me blog topics ideas Given Keywords. List dow ideas. with number list. Don't include duplicate. Keyword is " . $keyword,
    'max_tokens' => 500
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpcode != 200) {
    echo 'API request failed, HTTP response code: ' . $httpcode;
    exit;
}

curl_close($ch);

$response = json_decode($result);

if (!isset($response->choices[0]->text)) {
    echo 'No completions returned from API';
    exit;
}

$content = $response->choices[0]->text;

// Return the generated content as a JSON object
echo json_encode([
    'content' => $content,
]);

?>
