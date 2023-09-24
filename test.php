<?php
require_once 'db_connect.php';
$db = connect_db();

if ($db) {
    echo "Connection successful!";
    $db->close();
} else {
    echo "Connection failed!";
}
?>
