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
   GET ALL ADMINS
=============================== */

$result = $conn->query("
    SELECT *
    FROM admins
    ORDER BY id ASC
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>

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
                <i class="fas fa-users"></i>
                Manage Administrators
            </h1>

            <a href="admin-dashboard.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>
        <?php if (isset($_GET['success'])): ?>

            <div class="success-message">
                <i class="fas fa-circle-check"></i>
                Administrator added successfully.
            </div>

        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>

            <div class="success-message">
                <i class="fas fa-circle-check"></i>
                Administrator updated successfully.
            </div>

        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>

            <div class="success-message">
                <i class="fas fa-circle-check"></i>
                Administrator deleted successfully.
            </div>

        <?php endif; ?>

        <div class="admin-card">

            <div class="card-header">

                <h2>
                    <i class="fas fa-user-shield"></i>
                    Administrator Accounts
                </h2>

                <a href="add-admin.php" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Admin
                </a>

            </div>

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($admin = $result->fetch_assoc()): ?>

                        <tr>

                            <td><?= htmlspecialchars($admin['full_name']) ?></td>

                            <td><?= htmlspecialchars($admin['username']) ?></td>

                            <td>

                                <span class="role <?= strtolower(str_replace(' ', '-', $admin['role'])) ?>">

                                    <?= htmlspecialchars($admin['role']) ?>

                                </span>

                            </td>

                            <td>

                                <span class="status <?= strtolower($admin['status']) ?>">

                                    <?= htmlspecialchars($admin['status']) ?>

                                </span>

                            </td>

                            <td><?= date("M d, Y", strtotime($admin['created_at'])) ?></td>

                            <td>

                                <a
                                    href="edit-admin.php?id=<?= $admin['id'] ?>"
                                    class="btn-edit">

                                    Edit

                                </a>

                                <?php if ($admin['username'] != $_SESSION['admin']): ?>

                                    <a
                                        href="delete-admin.php?id=<?= $admin['id'] ?>"
                                        class="btn-delete"
                                        onclick="return confirm('Delete this admin?')">

                                        Delete

                                    </a>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>