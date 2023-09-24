<?php
function connect_db() {
    $db = new mysqli('localhost', 'root', '-asDOomHsuBoN27B', 'upto_cmsdb');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    return $db;
}
?>
