<?php
// Defaults; override by copying php/config.local.example.php to php/config.local.php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "chat";

if (is_readable(__DIR__ . "/config.local.php")) {
    require __DIR__ . "/config.local.php";
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database not connected: " . mysqli_connect_error());
}
?>