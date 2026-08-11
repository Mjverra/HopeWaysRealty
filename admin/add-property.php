<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property | HopeWays Realty</title>


    <link rel="stylesheet" href="../css/messages.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>



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
                        <label>Property Title <span class="required">*</span></label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="form-group">
                        <label>Property Type <span class="required">*</span></label>
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
                        <label>Location <span class="required">*</span></label>
                        <input type="text" name="location" required>
                    </div>

                    <div class="form-group">
                        <label>Price <span class="required">*</span></label>

                        <input
                            type="text"
                            name="price"
                            placeholder="Example: ₱10,000,000"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Price Option</label>

                        <select name="price_option">
                            <option value="Blank">Blank</option>
                            <option value="Negotiable">Negotiable</option>
                            <option value="Non-negotiable">Non-negotiable</option>
                        </select>
                    </div>

                </div>

            </div>

            <!-- ================= PROPERTY DETAILS ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    <i class="fas fa-circle-info"></i>
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
                        <input
                            type="text"
                            name="garage"
                            placeholder="Example: 1 Car">
                    </div>

                    <div class="form-group">
                        <label>Lot Area</label>
                        <input
                            type="text"
                            name="lot_area"
                            placeholder="Example: 360 sqm">
                    </div>

                    <div class="form-group">
                        <label>Floor Area</label>
                        <input
                            type="text"
                            name="floor_area"
                            placeholder="Example: 163.5 sqm">
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
                        <label>Status <span class="required">*</span></label>
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
                    <i class="fas fa-file-lines"></i>
                    Property Description
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
                    <i class="fas fa-star"></i>
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

            <!-- ================= LOCATION & COVER IMAGE ================= -->

            <div class="admin-card">

                <h3 class="section-title">
                    <i class="fas fa-location-dot"></i>
                    Location & Cover Image
                </h3>

                <div class="form-group">
                    <label>Google Maps URL</label>
                    <input
                        type="url"
                        name="map_url"
                        placeholder="https://www.google.com/maps?q=...">
                </div>

                <br>

                <div class="form-group">

                    <label>Property Cover Image <span class="required">*</span></label>

                    <input
                        type="file"
                        id="coverImage"
                        name="cover_image"
                        accept="image/*"
                        required>

                    <br><br>

                    <img
                        id="previewImage"
                        src=""
                        alt="Cover Image Preview"
                        style="
                        display:none;
                        width:100%;
                        max-width:350px;
                        border-radius:12px;
                        border:2px solid #ddd;
                        box-shadow:0 4px 12px rgba(0,0,0,.15);">

                </div>
                <hr style="margin:25px 0;">

                <div class="form-group">

                    <label>Property Gallery Images</label>

                    <input
                        type="file"
                        id="galleryImages"
                        name="gallery_images[]"
                        accept="image/*"
                        multiple>

                    <small>
                        You can select multiple images (Ctrl + Click or Shift + Click).
                    </small>

                </div>

                <div id="galleryPreview" class="gallery-preview"></div>

                <div class="form-buttons">

                    <a href="manage-properties.php" class="btn btn-secondary">
                        <i class="fas fa-xmark"></i>
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="saveBtn">

                        <i class="fas fa-floppy-disk"></i>
                        Save Property

                    </button>

                </div>

            </div>

        </form>
        <div id="loadingOverlay">

            <div class="loading-box">

                <i class="fas fa-spinner fa-spin"></i>

                <h3>Uploading Property...</h3>

                <p>Please wait while images are being uploaded.</p>

            </div>

        </div>
    </div>

    <script>
        document.getElementById("coverImage").addEventListener("change", function() {

            const file = this.files[0];

            if (file) {

                const reader = new FileReader();

                reader.onload = function(e) {

                    const preview = document.getElementById("previewImage");

                    preview.src = e.target.result;
                    preview.style.display = "block";

                };

                reader.readAsDataURL(file);
            }

        });


        const galleryInput = document.getElementById("galleryImages");
        const galleryPreview = document.getElementById("galleryPreview");

        galleryInput.addEventListener("change", function() {

            galleryPreview.innerHTML = "";

            [...this.files].forEach(file => {

                const reader = new FileReader();

                reader.onload = function(e) {

                    const img = document.createElement("img");

                    img.src = e.target.result;

                    galleryPreview.appendChild(img);

                };

                reader.readAsDataURL(file);

            });

        });
    </script>

    <script>
        document.querySelector("form").addEventListener("submit", function() {

            document.getElementById("loadingOverlay").style.display = "flex";

            const btn = document.getElementById("saveBtn");

            btn.disabled = true;

            btn.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Uploading...';

        });
    </script>
</body>

</html>