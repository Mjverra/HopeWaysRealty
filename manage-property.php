<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management | Hope Ways Realty</title>

    <link rel="stylesheet" href="css/messages.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<header class="top-header">

    <div class="header-content">

        <div>

            <h1>
                <i class="fas fa-building"></i>
                Property Management
            </h1>

            <p>
                Welcome,
                <strong><?php echo $_SESSION['admin']; ?></strong>
            </p>

        </div>

        <a href="logout.php" class="logout-btn">
            <i class="fas fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</header>

<section class="dashboard">

    <div class="dashboard-title">

        <h2>Properties</h2>

        <a href="add-property.php" class="add-btn">
            <i class="fas fa-plus"></i>
            Add Property
        </a>

    </div>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Property Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="7" class="empty-row">
                        No properties found.
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</section>

</body>
</html>