<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ==========================
   DASHBOARD STATISTICS
========================== */

// Total Properties
$totalProperties = $conn->query("
    SELECT COUNT(*) AS total
    FROM properties
")->fetch_assoc()['total'];

// Available Properties
$availableProperties = $conn->query("
    SELECT COUNT(*) AS total
    FROM properties
    WHERE status='Available'
")->fetch_assoc()['total'];

// Reserved Properties
$reservedProperties = $conn->query("
    SELECT COUNT(*) AS total
    FROM properties
    WHERE status='Reserved'
")->fetch_assoc()['total'];

// Sold Properties
$soldProperties = $conn->query("
    SELECT COUNT(*) AS total
    FROM properties
    WHERE status='Sold'
")->fetch_assoc()['total'];

// Unread Messages
$unreadMessages = $conn->query("
    SELECT COUNT(*) AS total
    FROM contact_messages
    WHERE is_read = 0
")->fetch_assoc()['total'];

// Total Admins
$totalAdmins = $conn->query("
    SELECT COUNT(*) AS total
    FROM admins
")->fetch_assoc()['total'];
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/dashboard.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include "admin-header.php"; ?>

<section class="dashboard">

    <div class="dashboard-title">

        <h2>
            <i class="fas fa-chart-line"></i>
            Dashboard
        </h2>

        <span>
            Welcome back,
            <strong><?= htmlspecialchars($_SESSION['admin']) ?></strong>
        </span>

    </div>

    <div class="stats-grid">

        <div class="stat-card">
            <i class="fas fa-house"></i>
            <h2><?= $totalProperties ?></h2>
            <p>Total Properties</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-circle-check"></i>
            <h2><?= $availableProperties ?></h2>
            <p>Available</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-clock"></i>
            <h2><?= $reservedProperties ?></h2>
            <p>Reserved</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-circle-xmark"></i>
            <h2><?= $soldProperties ?></h2>
            <p>Sold</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-envelope"></i>
            <h2><?= $unreadMessages ?></h2>
            <p>Unread Messages</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h2><?= $totalAdmins ?></h2>
            <p>Administrators</p>
        </div>

    </div>

</section>

</body>
</html>