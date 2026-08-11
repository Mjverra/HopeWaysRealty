<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ===============================
   GET ALL ADMINS
=============================== */

$result = $conn->query("
    SELECT *
    FROM admins
    ORDER BY id ASC
");

echo "<h1>Manage Admins</h1>";

echo "<p>Welcome, " . $_SESSION['admin'] . "</p>";

echo "<hr>";

while ($admin = $result->fetch_assoc()) {

    echo "<h3>" . htmlspecialchars($admin['full_name']) . "</h3>";

    echo "Username: " . htmlspecialchars($admin['username']) . "<br>";

    echo "Role: " . htmlspecialchars($admin['role']) . "<br>";

    echo "Status: " . htmlspecialchars($admin['status']) . "<br>";

    echo "<hr>";
}
