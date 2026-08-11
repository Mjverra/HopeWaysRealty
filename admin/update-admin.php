<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ===============================
   CHECK REQUEST
=============================== */

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: manage-admins.php");
    exit();
}

/* ===============================
   GET FORM DATA
=============================== */

$id        = (int) $_POST['id'];
$fullName  = trim($_POST['full_name']);
$username  = trim($_POST['username']);
$password  = trim($_POST['password']);
$role      = trim($_POST['role']);
$status    = trim($_POST['status']);

/* ===============================
   VALIDATION
=============================== */

if (
    empty($fullName) ||
    empty($username)
) {
    die("Please complete all required fields.");
}

/* ===============================
   CHECK IF USERNAME EXISTS
=============================== */

$check = $conn->prepare("
    SELECT id
    FROM admins
    WHERE username = ?
    AND id != ?
");

$check->bind_param("si", $username, $id);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
    die("Username already exists.");
}

$check->close();

/* ===============================
   UPDATE ADMIN
=============================== */

if (!empty($password)) {

    $stmt = $conn->prepare("
        UPDATE admins
        SET
            full_name = ?,
            username = ?,
            password = ?,
            role = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssssi",
        $fullName,
        $username,
        $password,
        $role,
        $status,
        $id
    );
} else {

    $stmt = $conn->prepare("
        UPDATE admins
        SET
            full_name = ?,
            username = ?,
            role = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssi",
        $fullName,
        $username,
        $role,
        $status,
        $id
    );
}

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();
$conn->close();

header("Location: manage-admins.php?updated=1");
exit();
