<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['role'] != "Super Admin") {
    header("Location: admin-dashboard.php");
    exit();
}
include "../includes/db_connect.php";

/* ==========================
   CHECK REQUEST
========================== */

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: add-admin.php");
    exit();
}

/* ==========================
   GET FORM DATA
========================== */

$fullName = trim($_POST['full_name']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirm_password']);
$role = trim($_POST['role']);
$status = trim($_POST['status']);

/* ==========================
   VALIDATION
========================== */

if (
    empty($fullName) ||
    empty($username) ||
    empty($password)
) {
    die("Please complete all required fields.");
}

if ($password != $confirmPassword) {
    die("Passwords do not match.");
}

/* ==========================
   CHECK DUPLICATE USERNAME
========================== */

$check = $conn->prepare("
    SELECT id
    FROM admins
    WHERE username = ?
");

$check->bind_param("s", $username);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
    die("Username already exists.");
}

$check->close();

/* ==========================
   INSERT ADMIN
========================== */

$stmt = $conn->prepare("
    INSERT INTO admins
    (
        full_name,
        username,
        password,
        role,
        status
    )
    VALUES
    (
        ?, ?, ?, ?, ?
    )
");

$stmt->bind_param(
    "sssss",
    $fullName,
    $username,
    $password,
    $role,
    $status
);

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();

$conn->close();

header("Location: manage-admins.php?success=1");
exit();
