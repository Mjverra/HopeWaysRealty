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
    <title>Add Property | HopeWays Realty</title>

    <link rel="stylesheet" href="css/messages.css">
    <link rel="stylesheet" href="css/admin.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <?php include "admin-header.php"; ?>

    <div class="admin-container">

        <div class="page-title">
            <h2>
                <i class="fas fa-plus-circle"></i>
                Add New Property
            </h2>

            <a href="manage-properties.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>

        <form action="save-property.php" method="POST" enctype="multipart/form-data">

            <!-- ================= PROPERTY INFORMATION ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    <i class="fas fa-house"></i>
                    Property Information
                </h3>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Property Title</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="form-group">
                        <label>Property Type</label>
                        <select name="property_type" required>
                            <option value="">Select Property Type</option>
                            <option>House & Lot</option>
                            <option>Townhouse</option>
                            <option>Residential Lot</option>
                            <option>Commercial Lot</option>
                            <option>Agricultural Land</option>
                            <option>Condominium</option>
                            <option>Office Space</option>
                            <option>Warehouse</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>Location</label>
                        <input type="text" name="location" required>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" required>
                    </div>

                </div>

            </div>

            <!-- ================= PROPERTY DETAILS ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    Property Details
                </h3>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Bedrooms</label>
                        <input type="number" name="bedrooms" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label>Bathrooms</label>
                        <input type="number" name="bathrooms" value="0" min="0">
                    </div>

                    <div class="form-group">
                        <label>Garage</label>
                        <input type="text" name="garage">
                    </div>

                    <div class="form-group">
                        <label>Lot Area</label>
                        <input type="text" name="lot_area">
                    </div>

                    <div class="form-group">
                        <label>Floor Area</label>
                        <input type="text" name="floor_area">
                    </div>

                    <div class="form-group">
                        <label>Furnishing</label>
                        <select name="furnishing">
                            <option value="">Select Furnishing</option>
                            <option>Fully Furnished</option>
                            <option>Semi-Furnished</option>
                            <option>Bare</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option>Available</option>
                            <option>Reserved</option>
                            <option>Sold</option>
                        </select>
                    </div>

                </div>

            </div>

            <!-- ================= DESCRIPTION ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    Description
                </h3>

                <div class="form-group">
                    <textarea
                        name="description"
                        rows="6"
                        placeholder="Enter the complete property description..."></textarea>
                </div>

            </div>

            <!-- ================= AMENITIES ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    Amenities
                </h3>

                <div class="form-group">
                    <textarea
                        name="amenities"
                        rows="5"
                        placeholder="Example:
Garage
Garden
Balcony
Fully Furnished
Water Tank"></textarea>
                </div>

            </div>

            <!-- ================= LOCATION & IMAGE ================= -->

            <div class="admin-card">

                <div class="form-group">
                    <label>Google Maps URL</label>
                    <input
                        type="url"
                        name="map_url"
                        placeholder="https://www.google.com/maps?q=...">
                </div>

                <br>

                <div class="form-group">
                    <label>Cover Image</label>
                    <input
                        type="file"
                        name="cover_image"
                        accept="image/*"
                        required>
                </div>

                <br>

                <div style="text-align:center;">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-floppy-disk"></i>
                        Save Property
                    </button>

                </div>

            </div>

        </form>

    </div>

</body>

</html>