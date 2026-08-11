<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ===============================
   SEARCH
================================ */

$search = $_GET['search'] ?? '';

$sql = "SELECT *
        FROM admins
        WHERE full_name LIKE ?
           OR username LIKE ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

$searchTerm = "%{$search}%";

$stmt->bind_param(
    "ss",
    $searchTerm,
    $searchTerm
);

$stmt->execute();

$result = $stmt->get_result();

/* ===============================
   DASHBOARD COUNTS
================================ */

$totalAdmins = $conn->query(
    "SELECT COUNT(*) total FROM admins"
)->fetch_assoc()['total'];

$superAdmins = $conn->query(
    "SELECT COUNT(*) total
     FROM admins
     WHERE role='Super Admin'"
)->fetch_assoc()['total'];

$activeAdmins = $conn->query(
    "SELECT COUNT(*) total
     FROM admins
     WHERE status='Active'"
)->fetch_assoc()['total'];

$inactiveAdmins = $conn->query(
    "SELECT COUNT(*) total
     FROM admins
     WHERE status='Inactive'"
)->fetch_assoc()['total'];
