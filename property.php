<?php
include "includes/db_connect.php";

/* ======================================
   CHECK PROPERTY ID
====================================== */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Property not found.");
}

$id = (int) $_GET['id'];

/* ======================================
   LOAD PROPERTY
====================================== */

$sql = "
    SELECT *
    FROM properties
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Property not found.");
}

$property = $result->fetch_assoc();

$stmt->close();

/* ======================================
   LOAD PROPERTY GALLERY
====================================== */

$gallerySql = "
    SELECT *
    FROM property_images
    WHERE property_id = ?
    ORDER BY image_order ASC
";

$galleryStmt = $conn->prepare($gallerySql);
$galleryStmt->bind_param("i", $id);
$galleryStmt->execute();

$galleryResult = $galleryStmt->get_result();

/* ======================================
   LOAD RELATED PROPERTIES
====================================== */

$relatedSql = "
    SELECT *
    FROM properties
    WHERE id != ?
    ORDER BY RAND()
    LIMIT 3
";

$relatedStmt = $conn->prepare($relatedSql);
$relatedStmt->bind_param("i", $id);
$relatedStmt->execute();

$relatedProperties = $relatedStmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($property['title']); ?> | HopeWays Realty
    </title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/property.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

</head>

<body>
    <!-- Back Bar -->
    <div class="back-bar">

        <div class="container">

            <a href="properties.php" class="back-btn">

                <i class="fas fa-arrow-left"></i>

                Back to Properties

            </a>

            <div class="logo">
                <a href="index.php">
                    <img
                        src="images/logo/headerlogo.jpg"
                        class="header-logo"
                        alt="Hope Ways Realty">

                    <span>HopeWays Realty</span>
                </a>
            </div>

        </div>

    </div>

    </div>