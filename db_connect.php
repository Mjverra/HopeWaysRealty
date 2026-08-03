<?php
$host = getenv("MYSQLHOST");
$port = getenv("MYSQLPORT");
$dbname = getenv("MYSQLDATABASE");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>