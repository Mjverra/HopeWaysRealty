<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change Password</title>

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
                <i class="fas fa-key"></i>
                Change Password
            </h1>

        </div>

        <?php if (isset($_GET['success'])): ?>

            <div class="success-message">

                <i class="fas fa-circle-check"></i>

                Password updated successfully.

            </div>

        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>

            <div class="error-message">

                <i class="fas fa-circle-xmark"></i>

                <?= htmlspecialchars($_GET['error']) ?>

            </div>

        <?php endif; ?>

        <div class="admin-card">

            <form action="update-password.php" method="POST">

                <div class="form-group">

                    <label>Current Password</label>

                    <input
                        type="password"
                        name="current_password"
                        required>

                </div>

                <div class="form-group">

                    <label>New Password</label>

                    <input
                        type="password"
                        name="new_password"
                        required>

                </div>

                <div class="form-group">

                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="confirm_password"
                        required>

                </div>

                <button class="btn-primary">

                    <i class="fas fa-floppy-disk"></i>

                    Update Password

                </button>

            </form>

        </div>

    </div>

</body>

</html>