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
/* ======================================
   LOAD GALLERY IMAGES
====================================== */

$gallery = [];

$stmt = $conn->prepare("
    SELECT *
    FROM property_images
    WHERE property_id = ?
    ORDER BY image_order ASC
");

$stmt->bind_param("i", $id);
$stmt->execute();

$resultGallery = $stmt->get_result();

while ($row = $resultGallery->fetch_assoc()) {

    $gallery[] = $row;
}

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

            <div class="page-brand">

                <img
                    src="images/logo/headerlogo.jpg"
                    alt="HopeWays Realty Logo"
                    class="page-logo-image">

                <h2 class="page-logo">
                    HopeWays Realty
                </h2>

            </div>

        </div>

    </div>
    <!-- ======================================
     HERO SECTION
====================================== -->

    <section class="property-hero">

        <img
            src="<?= htmlspecialchars($property['cover_image']); ?>"
            alt="<?= htmlspecialchars($property['title']); ?>">

        <div class="hero-overlay">

            <div class="container">

                <div class="hero-content">

                    <span class="property-status">

                        <?= htmlspecialchars($property['status']); ?>

                    </span>

                    <h1>

                        <?= htmlspecialchars($property['title']); ?>

                    </h1>

                    <h2>

                        ₱<?= number_format($property['price'], 2); ?>

                    </h2>

                    <p class="hero-location">

                        <i class="fas fa-map-marker-alt"></i>

                        <?= htmlspecialchars($property['location']); ?>

                    </p>

                </div>

            </div>

        </div>

    </section>
    <!-- ======================================
     PROPERTY INFORMATION
====================================== -->

    <section class="property-details">

        <div class="container">

            <div class="section-title">

                <h2>
                    Property Information
                </h2>

                <p>
                    Complete details of this property.
                </p>

            </div>

            <div class="details-grid">

                <div class="detail-card">
                    <i class="fas fa-house"></i>
                    <h4>Property Type</h4>
                    <p><?= htmlspecialchars($property['property_type']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-bed"></i>
                    <h4>Bedrooms</h4>
                    <p><?= htmlspecialchars($property['bedrooms']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-bath"></i>
                    <h4>Bathrooms</h4>
                    <p><?= htmlspecialchars($property['bathrooms']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-car"></i>
                    <h4>Garage</h4>
                    <p><?= htmlspecialchars($property['garage']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-vector-square"></i>
                    <h4>Lot Area</h4>
                    <p><?= htmlspecialchars($property['lot_area']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-ruler-combined"></i>
                    <h4>Floor Area</h4>
                    <p><?= htmlspecialchars($property['floor_area']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-couch"></i>
                    <h4>Furnishing</h4>
                    <p><?= htmlspecialchars($property['furnishing']); ?></p>
                </div>

                <div class="detail-card">
                    <i class="fas fa-circle-check"></i>
                    <h4>Status</h4>
                    <p><?= htmlspecialchars($property['status']); ?></p>
                </div>

            </div>

        </div>

    </section>
    <!-- ======================================
     PROPERTY GALLERY
====================================== -->

    <section class="property-gallery">

        <div class="container">

            <div class="section-title">

                <h2>

                    Property Gallery

                </h2>

                <p>

                    Browse all available photos of this property.

                </p>

            </div>

            <?php if (count($gallery) > 0): ?>

                <div class="gallery-grid">

                    <?php foreach ($gallery as $image): ?>

                        <div class="gallery-item">

                            <img
                                src="<?= htmlspecialchars($image['image_path']); ?>"
                                alt="Gallery Image">

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>

                <div class="no-gallery">

                    <i class="fas fa-image"></i>

                    <h3>No Gallery Images</h3>

                    <p>
                        No additional images have been uploaded for this property.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </section>