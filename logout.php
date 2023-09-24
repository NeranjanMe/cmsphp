<?php
session_start();
session_unset();  // Free all session variables
session_destroy(); // Destroy the session
header("Location: login.php");
exit();
?>