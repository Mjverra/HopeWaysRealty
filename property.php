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

        <div class="hero-image-wrapper">

            <img
                src="<?= htmlspecialchars($property['cover_image']); ?>"
                alt="<?= htmlspecialchars($property['title']); ?>">

        </div>

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

                    <?php
                    $visibleImages = array_slice($gallery, 0, 7);

                    foreach ($visibleImages as $image):
                    ?>

                        <div class="gallery-item">
                            <img
                                src="<?= htmlspecialchars($image['image_path']) ?>"
                                alt="Gallery Image">
                        </div>

                    <?php endforeach; ?>


                    <?php if (count($gallery) > 7): ?>

                        <div
                            class="gallery-item more-photos"
                            onclick="openLightbox(7)">

                            <div class="more-overlay">

                                +<?= count($gallery) - 7 ?>

                                <br>

                                More Photos

                            </div>

                        </div>

                    <?php endif; ?>

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
    <!-- ======================================
     LIGHTBOX
====================================== -->

    <div class="lightbox" id="lightbox">

        <span class="close-lightbox">&times;</span>

        <span class="prev-image">&#10094;</span>

        <img id="lightbox-image" src="" alt="Gallery Image">

        <span class="next-image">&#10095;</span>

    </div>

    <script>
        const galleryImages = [
            <?php foreach ($gallery as $image): ?> {
                    src: "<?= htmlspecialchars($image['image_path']); ?>"
                },
            <?php endforeach; ?>
        ];

        const lightbox = document.getElementById("lightbox");

        const lightboxImage = document.getElementById("lightbox-image");

        const closeBtn = document.querySelector(".close-lightbox");

        const prevBtn = document.querySelector(".prev-image");

        const nextBtn = document.querySelector(".next-image");

        let currentIndex = 0;

        document.querySelectorAll(".gallery-item img").forEach((image, index) => {

            image.addEventListener("click", () => {

                currentIndex = index;

                showImage();

                lightbox.style.display = "flex";

            });

        });

        function openLightbox(index) {

            currentIndex = index;

            showImage();

            lightbox.style.display = "flex";

        }

        function showImage() {

            lightboxImage.src = galleryImages[currentIndex].src;

        }

        nextBtn.addEventListener("click", () => {

            currentIndex++;

            if (currentIndex >= galleryImages.length) {

                currentIndex = 0;

            }

            showImage();

        });

        prevBtn.addEventListener("click", () => {

            currentIndex--;

            if (currentIndex < 0) {

                currentIndex = galleryImages.length - 1;

            }

            showImage();

        });

        closeBtn.addEventListener("click", () => {

            lightbox.style.display = "none";

        });

        lightbox.addEventListener("click", (e) => {

            if (e.target === lightbox) {

                lightbox.style.display = "none";

            }

        });
    </script>
    <!-- ======================================
     PROPERTY DESCRIPTION
====================================== -->

    <section class="property-description">

        <div class="container">

            <div class="section-title">

                <h2>Property Description</h2>

                <p>Learn more about this property.</p>

            </div>

            <div class="description-card">

                <?= nl2br(htmlspecialchars($property['description'])); ?>

            </div>

        </div>

    </section>
    <!-- ======================================
     PROPERTY AMENITIES
====================================== -->

    <section class="property-amenities">

        <div class="container">

            <div class="section-title">

                <h2>Property Amenities</h2>

                <p>Features and amenities included with this property.</p>

            </div>

            <div class="amenities-card">

                <?php
                $amenities = array_filter(array_map('trim', explode(",", $property['amenities'])));

                if (!empty($amenities)):
                ?>

                    <div class="amenities-grid">

                        <?php foreach ($amenities as $amenity): ?>

                            <div class="amenity-item">

                                <i class="fas fa-check-circle"></i>

                                <span><?= htmlspecialchars($amenity); ?></span>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <p class="no-amenities">
                        No amenities have been added for this property.
                    </p>

                <?php endif; ?>

            </div>

        </div>

    </section>
    <!-- ======================================
     PROPERTY LOCATION
====================================== -->

    <section class="property-map">

        <div class="container">

            <div class="section-title">

                <h2>Property Location</h2>

                <p>View the property's location on Google Maps.</p>

            </div>

            <?php if (!empty($property['map_url'])): ?>

                <div class="map-card">

                    <iframe
                        src="<?= htmlspecialchars($property['map_url']); ?>"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>

            <?php else: ?>

                <div class="no-map">

                    <i class="fas fa-map-marked-alt"></i>

                    <h3>Location Not Available</h3>

                    <p>No map has been added for this property.</p>

                </div>

            <?php endif; ?>

        </div>

    </section>
    <!-- ======================================
     PROPERTY INQUIRY
====================================== -->

    <section class="property-inquiry">

        <div class="container">

            <div class="inquiry-box">

                <h2>

                    Interested in this Property?

                </h2>

                <p>

                    Contact HopeWays Realty today to schedule a property viewing or request more information about this listing.

                </p>

                <a
                    href="contact.php?property=<?= urlencode($property['title']); ?>"
                    class="inquiry-btn">

                    <i class="fas fa-paper-plane"></i>

                    Send Inquiry

                </a>

            </div>

        </div>

    </section>
    <!-- ======================================
     RELATED PROPERTIES
====================================== -->

    <section class="related-properties">

        <div class="container">

            <div class="section-title">

                <h2>Related Properties</h2>

                <p>You may also be interested in these listings.</p>

            </div>

            <div class="related-grid">

                <?php while ($related = $relatedProperties->fetch_assoc()): ?>

                    <div class="related-card">

                        <img
                            src="<?= htmlspecialchars($related['cover_image']); ?>"
                            alt="<?= htmlspecialchars($related['title']); ?>">

                        <div class="related-content">

                            <h3>

                                <?= htmlspecialchars($related['title']); ?>

                            </h3>

                            <p>

                                <i class="fas fa-map-marker-alt"></i>

                                <?= htmlspecialchars($related['location']); ?>

                            </p>

                            <h4>

                                ₱<?= number_format($related['price'], 2); ?>

                            </h4>

                            <a
                                href="property.php?id=<?= $related['id']; ?>"
                                class="related-btn">

                                View Property

                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>

    </section>
    <script>
        const heroImage = document.getElementById("mainHeroImage");

        const heroThumbs = document.querySelectorAll(".hero-thumb");

        heroThumbs.forEach((thumb) => {

            thumb.addEventListener("click", function() {

                heroImage.src = this.src;

                heroThumbs.forEach(t => t.classList.remove("active-thumb"));

                this.classList.add("active-thumb");

            });

        });
    </script>
</body>