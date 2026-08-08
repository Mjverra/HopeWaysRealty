<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

/* ======================================
   CHECK PROPERTY ID
====================================== */

if (!isset($_GET['id']) || empty($_GET['id'])) {

    header("Location: manage-properties.php");
    exit();

}

$id = (int) $_GET['id'];

/* ======================================
   LOAD PROPERTY
====================================== */

$stmt = $conn->prepare(
    "SELECT *
     FROM properties
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: manage-properties.php");
    exit();

}

$property = $result->fetch_assoc();

$stmt->close();

/* ======================================
   LOAD GALLERY IMAGES
====================================== */

$gallery = [];

$sql = $conn->prepare(
    "SELECT *
     FROM property_images
     WHERE property_id = ?
     ORDER BY id ASC"
);

$sql->bind_param("i", $id);

$sql->execute();

$images = $sql->get_result();

while($row = $images->fetch_assoc()){

    $gallery[] = $row;

}

$sql->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Property | HopeWays Realty</title>

    <link rel="stylesheet" href="../css/messages.css">
    <link rel="stylesheet" href="../css/admin.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include "admin-header.php"; ?>

<div class="admin-container">

    <div class="page-title">

        <h2>

            <i class="fas fa-pen-to-square"></i>

            Edit Property

        </h2>

        <a href="manage-properties.php" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Back

        </a>

    </div>

<form
    action="update-property.php"
    method="POST"
    enctype="multipart/form-data">

<input
    type="hidden"
    name="id"
    value="<?php echo $property['id']; ?>">
    <div class="admin-card">
        <input
    type="hidden"
    id="deletedImages"
    name="deleted_images"
    value="">

<h3 class="section-title">

<i class="fas fa-house"></i>

Property Information

</h3>

<div class="form-grid">

<div class="form-group">

<label>Property Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($property['title']); ?>"
required>

</div>

<div class="form-group">

<label>Property Type</label>

<select name="property_type" required>

<?php

$types = [

"House & Lot",
"Townhouse",
"Residential Lot",
"Commercial Lot",
"Agricultural Land",
"Condominium",
"Office Space",
"Warehouse"

];

foreach($types as $type){

    $selected =
        $property['property_type'] == $type
        ? "selected"
        : "";

    echo "<option $selected>$type</option>";

}

?>

</select>

</div>

<div class="form-group full-width">

<label>Location</label>

<input
type="text"
name="location"
value="<?php echo htmlspecialchars($property['location']); ?>"
required>

</div>

<div class="form-group">

<label>Price</label>

<input
type="text"
name="price"
value="<?php echo htmlspecialchars($property['price']); ?>"
required>

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

            <input
                type="number"
                name="bedrooms"
                value="<?php echo $property['bedrooms']; ?>"
                min="0">

        </div>

        <div class="form-group">

            <label>Bathrooms</label>

            <input
                type="number"
                name="bathrooms"
                value="<?php echo $property['bathrooms']; ?>"
                min="0">

        </div>

        <div class="form-group">

            <label>Garage</label>

            <input
                type="text"
                name="garage"
                value="<?php echo htmlspecialchars($property['garage']); ?>">

        </div>

        <div class="form-group">

            <label>Lot Area</label>

            <input
                type="text"
                name="lot_area"
                value="<?php echo htmlspecialchars($property['lot_area']); ?>">

        </div>

        <div class="form-group">

            <label>Floor Area</label>

            <input
                type="text"
                name="floor_area"
                value="<?php echo htmlspecialchars($property['floor_area']); ?>">

        </div>

        <div class="form-group">

            <label>Furnishing</label>

            <select name="furnishing">

                <?php

                $furnishing = [

                    "",

                    "Fully Furnished",

                    "Semi-Furnished",

                    "Bare"

                ];

                foreach($furnishing as $item){

                    $selected =
                        $property['furnishing'] == $item
                        ? "selected"
                        : "";

                    echo "<option $selected>$item</option>";

                }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select name="status">

                <?php

                $status = [

                    "Available",

                    "Reserved",

                    "Sold"

                ];

                foreach($status as $item){

                    $selected =
                        $property['status'] == $item
                        ? "selected"
                        : "";

                    echo "<option $selected>$item</option>";

                }

                ?>

            </select>

        </div>

    </div>

</div>
<!-- ================= COVER IMAGE ================= -->

<div class="admin-card">

    <h3 class="section-title">

        <i class="fas fa-image"></i>

        Cover Image

    </h3>

    <div style="text-align:center;">

        <?php if(!empty($property['cover_image'])){ ?>

            <img
                src="<?php echo htmlspecialchars($property['cover_image']); ?>"
                id="previewImage"
                style="width:320px;
                       border-radius:12px;
                       border:1px solid #ddd;
                       margin-bottom:20px;">

        <?php }else{ ?>

            <img
                src="../images/default/no-image.png"
                id="previewImage"
                style="width:320px;
                       border-radius:12px;
                       border:1px solid #ddd;
                       margin-bottom:20px;">

        <?php } ?>

        <div class="form-group">

            <label>Replace Cover Image</label>

            <input
                type="file"
                id="coverImage"
                name="cover_image"
                accept="image/*">
                
                <small>

                Leave this blank if you don't want to replace the current cover image.

            </small>

        </div>

    </div>

</div>
<!-- =======================================================
     PROPERTY DESCRIPTION
======================================================== -->

<div class="admin-card">

    <h3 class="section-title">

        <i class="fas fa-file-lines"></i>

        Property Description

    </h3>

    <div class="form-group">

        <textarea
            name="description"
            rows="7"
            placeholder="Enter property description..."><?php echo htmlspecialchars($property['description']); ?></textarea>

    </div>

</div>

<!-- =======================================================
     AMENITIES
======================================================== -->

<div class="admin-card">

    <h3 class="section-title">

        <i class="fas fa-star"></i>

        Amenities

    </h3>

    <div class="form-group">

        <textarea
            name="amenities"
            rows="6"
            placeholder="Garage&#10;Garden&#10;Swimming Pool&#10;Balcony"><?php echo htmlspecialchars($property['amenities']); ?></textarea>

    </div>

</div>

<!-- =======================================================
     LOCATION
======================================================== -->

<div class="admin-card">

    <h3 class="section-title">

        <i class="fas fa-location-dot"></i>

        Google Maps

    </h3>

    <div class="form-group">

        <label>Google Maps URL</label>

        <input
            type="url"
            name="map_url"
            value="<?php echo htmlspecialchars($property['map_url']); ?>"
            placeholder="https://www.google.com/maps?q=...">

    </div>

</div>
<!-- =======================================================
     GALLERY IMAGES
======================================================== -->

<div class="admin-card">

    <h3 class="section-title">

        <i class="fas fa-images"></i>

        Property Gallery

    </h3>

    <?php if(count($gallery) > 0){ ?>

    <div class="gallery-grid">

        <?php foreach($gallery as $image){ ?>

            <div
    class="gallery-item"
    id="gallery-image-<?php echo $image['id']; ?>">

                <img
                    src="<?php echo htmlspecialchars($image['image_path']); ?>"
                    alt="Gallery Image">

                <br><br>

                <button
    type="button"
    class="btn btn-danger delete-gallery-btn"
    data-image-id="<?php echo $image['id']; ?>">

    <i class="fas fa-trash"></i>

    Delete

</button>

            </div>

        <?php } ?>

    </div>

    <?php }else{ ?>

        <p style="color:#777;text-align:center;">

            No gallery images uploaded.

        </p>

    <?php } ?>

    <hr style="margin:30px 0;">

    <div class="form-group">

        <label>

            Upload More Images

        </label>

        <input
            type="file"
            name="gallery_images[]"
            id="galleryImages"
            accept="image/*"
            multiple>

    </div>

    <div id="galleryPreview" class="gallery-preview"></div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const coverImage =
        document.getElementById("coverImage");

    if(coverImage){

        coverImage.addEventListener("change", function(){

            const file = this.files[0];

            if(file){

                const reader = new FileReader();

                reader.onload = function(e){

                    document.getElementById("previewImage").src =
                        e.target.result;

                }

                reader.readAsDataURL(file);

            }

        });

    }

});

</script>
<div class="form-buttons">

    <a
        href="manage-properties.php"
        class="btn btn-secondary">

        <i class="fas fa-xmark"></i>

        Cancel

    </a>

    <button
    type="submit"
    class="btn btn-primary"
    id="updateBtn">

    <i class="fas fa-floppy-disk"></i>
    Update Property

</button>

</div>


</form>

<!-- Loading Overlay -->
<div id="loadingOverlay">

    <div class="loading-box">

        <i class="fas fa-spinner fa-spin"></i>

        <h3>Updating Property...</h3>

        <p>Please wait while changes are being saved.</p>

    </div>

</div>



</body>
</html>
</div>

<script>

const galleryInput =
document.getElementById("galleryImages");

if(galleryInput){

galleryInput.addEventListener("change", function(){

    const preview =
    document.getElementById("galleryPreview");

    preview.innerHTML = "";

    [...this.files].forEach(file=>{

        const reader =
        new FileReader();

        reader.onload=function(e){

            preview.innerHTML +=
            `<img src="${e.target.result}"
                  style="
                    width:150px;
                    margin:10px;
                    border-radius:10px;
                    border:1px solid #ddd;">`;

        }

        reader.readAsDataURL(file);

    });

});

}

</script>
<script>

const deletedImages = [];

document.querySelectorAll(".delete-gallery-btn").forEach(button => {

    button.addEventListener("click", function () {

        const imageId = this.dataset.imageId;

        // don't add twice
        if (!deletedImages.includes(imageId)) {
            deletedImages.push(imageId);
        }

        // update hidden input
        document.getElementById("deletedImages").value =
            deletedImages.join(",");

        // hide image
        document.getElementById("gallery-image-" + imageId)
            .style.display = "none";

    });

});

</script>
<script>
document.querySelector("form").addEventListener("submit", function () {

    document.getElementById("loadingOverlay").style.display = "flex";

    const btn = document.getElementById("updateBtn");

    btn.disabled = true;

    btn.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> Updating...';

});
</script>
</body>

</html>
