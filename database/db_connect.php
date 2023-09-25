<?php
function connect_db() {
    $db = new mysqli('localhost', 'onemhmce_cmsphp', 'GE_g;shKkluw', 'onemhmce_cmsphpdb');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    return $db;
}
?>
