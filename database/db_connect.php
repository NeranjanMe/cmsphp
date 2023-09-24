<?php
$servername = "localhost";
$database = "upto_cmsdb";
$username = "upto_root";
$password = "-asDOomHsuBoN27B";
 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
 
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . " - " . mysqli_connect_errno());
}
echo "Connected successfully";
mysqli_close($conn);

?>
