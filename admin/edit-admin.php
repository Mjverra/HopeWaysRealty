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

/* ===============================
   CHECK ADMIN ID
=============================== */

if (!isset($_GET['id'])) {
    header("Location: manage-admins.php");
    exit();
}

$id = (int) $_GET['id'];

/* ===============================
   LOAD ADMIN
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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Administrator</title>

    <link rel="stylesheet" href="../css/admin-header.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <?php include "admin-header.php"; ?>

    <div class="container">

        <div class="page-header">

            <h1>
                <i class="fas fa-user-edit"></i>
                Edit Administrator
            </h1>

            <a href="manage-admins.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>

        <div class="admin-card">

            <form action="update-admin.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $admin['id'] ?>">

                <div class="form-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        value="<?= htmlspecialchars($admin['full_name']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        value="<?= htmlspecialchars($admin['username']) ?>"
                        required>

                </div>

                <div class="form-group">

                    <label>New Password</label>

                    <input
                        type="password"
                        name="password">

                    <small>
                        Leave blank if you don't want to change the password.
                    </small>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role">

                        <option value="Super Admin"
                            <?= $admin['role'] == 'Super Admin' ? 'selected' : '' ?>>
                            Super Admin
                        </option>

                        <option value="Admin"
                            <?= $admin['role'] == 'Admin' ? 'selected' : '' ?>>
                            Admin
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="status">

                        <option value="Active"
                            <?= $admin['status'] == 'Active' ? 'selected' : '' ?>>
                            Active
                        </option>

                        <option value="Inactive"
                            <?= $admin['status'] == 'Inactive' ? 'selected' : '' ?>>
                            Inactive
                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    class="btn-primary">

                    <i class="fas fa-save"></i>

                    Update Administrator

                </button>

            </form>

        </div>

    </div>

</body>

</html>