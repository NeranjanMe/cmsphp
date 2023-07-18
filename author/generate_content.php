<?php

$keyword = $_POST['keyword'];

$api_key = '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';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/engines/text-davinci-002/completions');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer ' . $api_key;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = json_encode([
    'prompt' => "Write an article for this keyword: " . $keyword,
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

$title = $response->choices[0]->text;
$content = $response->choices[0]->text;
$meta_title = $response->choices[0]->text;
$meta_description = $response->choices[0]->text;

$title = str_replace('\n\n', ' ', $title); // Replaces double newlines with a space
$title = str_replace('\n', ' ', $title); // Replaces single newlines with a space

$content = str_replace('\n\n', ' ', $content); // Replaces double newlines with a space
$content = str_replace('\n', ' ', $content); // Replaces single newlines with a space

$meta_title = str_replace('\n\n', ' ', $meta_title); // Replaces double newlines with a space
$meta_title = str_replace('\n', ' ', $meta_title); // Replaces single newlines with a space

$meta_description = str_replace('\n\n', ' ', $meta_description); // Replaces double newlines with a space
$meta_description = str_replace('\n', ' ', $meta_description); // Replaces single newlines with a space

// Return the generated content as a JSON object
echo json_encode([
    'title' => $title,
    'content' => $content,
    'meta_title' => $meta_title,
    'meta_description' => $meta_description,
]);

?>
