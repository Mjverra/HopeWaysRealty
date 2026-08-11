<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

echo "<h1>Manage Admins</h1>";

echo "<p>Welcome, " . $_SESSION['admin'] . "</p>";
