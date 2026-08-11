<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ===============================
   CHECK ADMIN ID
=============================== */

if (!isset($_GET['id'])) {
    header("Location: manage-admins.php");
    exit();
}

$id = (int) $_GET['id'];

/* ===============================
   LOAD ADMIN TO DELETE
=============================== */

$stmt = $conn->prepare("
    SELECT *
    FROM admins
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage-admins.php");
    exit();
}

$admin = $result->fetch_assoc();
$stmt->close();

/* ===============================
   DON'T DELETE YOURSELF
=============================== */

if ($admin['username'] == $_SESSION['admin']) {
    die("You cannot delete your own account.");
}

/* ===============================
   DON'T DELETE LAST SUPER ADMIN
=============================== */

if ($admin['role'] == "Super Admin") {

    $count = $conn->query("
        SELECT COUNT(*) AS total
        FROM admins
        WHERE role='Super Admin'
        AND status='Active'
    ");

    $row = $count->fetch_assoc();

    if ($row['total'] <= 1) {
        die("The last active Super Admin cannot be deleted.");
    }
}

/* ===============================
   DELETE ADMIN
=============================== */

$delete = $conn->prepare("
    DELETE
    FROM admins
    WHERE id = ?
");

$delete->bind_param("i", $id);

if (!$delete->execute()) {
    die("Database Error: " . $delete->error);
}

$delete->close();
$conn->close();

header("Location: manage-admins.php?deleted=1");
exit();
