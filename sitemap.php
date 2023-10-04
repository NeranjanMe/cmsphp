<?php
// sitemap.php in the root directory

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require_once 'database/db_connect.php';
$db = connect_db();

// Fetch site domain from the settings table
$domainQuery = "SELECT domain FROM settings LIMIT 1";
$domainResult = $db->query($domainQuery);
if (!$domainResult) {
    die("Database query failed: " . $db->error);
}
$settings = $domainResult->fetch_assoc();
$siteDomain = $settings['domain']; // Assuming 'domain' has a value like 'https://uptoware.com'

// Fetch all posts
$query = "SELECT permalink, updated_at FROM posts ORDER BY updated_at DESC";
$result = $db->query($query);
if (!$result) {
    die("Database query failed: " . $db->error);
}

// Set header for XML output
header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Loop through each post and echo the XML structure
while ($post = $result->fetch_assoc()) {
    $postUrl = $siteDomain . '/' . $post['permalink']; 
    $lastMod = date(DATE_W3C, strtotime($post['updated_at']));

    echo "<url>";
    echo "<loc>${postUrl}</loc>";
    echo "<lastmod>${lastMod}</lastmod>";
    echo "<changefreq>weekly</changefreq>"; 
    echo "</url>";
}

echo '</urlset>';
?>
