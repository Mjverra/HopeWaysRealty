<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

$current_password = trim($_POST['current_password']);
$new_password     = trim($_POST['new_password']);
$confirm_password = trim($_POST['confirm_password']);

$username = $_SESSION['admin'];

/* ==========================
   GET CURRENT ADMIN
========================== */

$stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows != 1) {

    header("Location: change-password.php?error=Administrator not found.");
    exit();
}

$admin = $result->fetch_assoc();

/* ==========================
   VERIFY CURRENT PASSWORD
========================== */

if ($current_password != $admin['password']) {

    header("Location: change-password.php?error=Current password is incorrect.");
    exit();
}

/* ==========================
   VERIFY NEW PASSWORDS MATCH
========================== */

if ($new_password != $confirm_password) {

    header("Location: change-password.php?error=New passwords do not match.");
    exit();
}
/* ==========================
   CHECK IF NEW PASSWORD IS THE SAME
========================== */

if ($new_password == $current_password) {

    header("Location: change-password.php?error=Your new password must be different from your current password.");
    exit();
}
/* ==========================
   CHECK PASSWORD LENGTH
========================== */

if (strlen($new_password) < 6) {

    header("Location: change-password.php?error=Password must be at least 6 characters.");
    exit();
}

/* ==========================
   UPDATE PASSWORD
========================== */

$stmt = $conn->prepare("UPDATE admins SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $new_password, $username);

if ($stmt->execute()) {

    header("Location: change-password.php?success=1");
    exit();
} else {

    header("Location: change-password.php?error=Unable to update password.");
    exit();
}
