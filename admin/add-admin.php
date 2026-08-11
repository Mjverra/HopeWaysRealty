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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Administrator</title>

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
                <i class="fas fa-user-plus"></i>
                Add Administrator
            </h1>

            <a href="manage-admins.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>

        <div class="admin-card">

            <form action="save-admin.php" method="POST">

                <div class="form-group">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="full_name"
                        required>

                </div>

                <div class="form-group">

                    <label>Username</label>

                    <input
                        type="text"
                        name="username"
                        required>

                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        required>

                </div>

                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirm_password"
                        required>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role">

                        <option value="Super Admin">Super Admin</option>

                        <option value="Admin">Admin</option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Status</label>

                    <select name="status">

                        <option value="Active">Active</option>

                        <option value="Inactive">Inactive</option>

                    </select>

                </div>

                <button type="submit" class="btn-primary">

                    <i class="fas fa-save"></i>

                    Save Administrator

                </button>

            </form>

        </div>

    </div>

</body>

</html>