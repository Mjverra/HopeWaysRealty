<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";
require_once "../includes/cloudinary.php";

/* ==============================
   CHECK PROPERTY ID
============================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: manage-properties.php");
    exit();
}

$id = intval($_POST['id']);

/* ==============================
   LOAD EXISTING PROPERTY
============================== */

$stmt = $conn->prepare("SELECT * FROM properties WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage-properties.php");
    exit();
}

$property = $result->fetch_assoc();
$stmt->close();



/* ==============================
   GET FORM VALUES
============================== */

$title          = trim($_POST['title']);
$property_type  = trim($_POST['property_type']);
$location       = trim($_POST['location']);
$price          = trim($_POST['price']);

$bedrooms       = intval($_POST['bedrooms']);
$bathrooms      = intval($_POST['bathrooms']);

$garage         = trim($_POST['garage']);
$lot_area       = trim($_POST['lot_area']);
$floor_area     = trim($_POST['floor_area']);

$furnishing     = trim($_POST['furnishing']);
$status         = trim($_POST['status']);

$description    = trim($_POST['description']);
$amenities      = trim($_POST['amenities']);
$map_url        = trim($_POST['map_url']);

$cover_image = $property['cover_image'];
$cover_public_id = $property['cover_public_id'];


/* ==============================
   REPLACE COVER IMAGE
============================== */

if (
    isset($_FILES['cover_image']) &&
    $_FILES['cover_image']['error'] == 0
) {

    $allowedExtensions = ['jpg','jpeg','png','webp'];

    $extension = strtolower(pathinfo(
        $_FILES['cover_image']['name'],
        PATHINFO_EXTENSION
    ));

    if (!in_array($extension, $allowedExtensions)) {
        die("Invalid cover image format.");
    }

    if ($_FILES['cover_image']['size'] > 10 * 1024 * 1024) {
        die("Cover image exceeds 10MB.");
    }

    $mime = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (strpos($mime, "image/") !== 0) {
        die("Invalid image.");
    }

    try {
if (!empty($property['cover_public_id'])) {

    $cloudinary->uploadApi()->destroy(
        $property['cover_public_id'],
        [
            "resource_type" => "image",
            "invalidate" => true
        ]
    );

}
        $upload = $cloudinary->uploadApi()->upload(
            
            $_FILES['cover_image']['tmp_name'],
            [
                "folder" => "hopeways/properties",
                "public_id" => "property_" . $id . "_cover",
                "overwrite" => true,
                "resource_type" => "image"
            ]
        );

        $cover_image = $upload->offsetGet('secure_url');
$cover_public_id = $upload->offsetGet('public_id');

    } catch (Exception $e) {

        die("Cloudinary Upload Failed:<br>" . $e->getMessage());

    }
}
/* ==============================
   UPDATE PROPERTY DETAILS
============================== */

$stmt = $conn->prepare("
UPDATE properties SET
    title=?,
    property_type=?,
    location=?,
    price=?,
    bedrooms=?,
    bathrooms=?,
    garage=?,
    lot_area=?,
    floor_area=?,
    furnishing=?,
    status=?,
    description=?,
    amenities=?,
    map_url=?,
    cover_image=?,
cover_public_id=?,
updated_at=NOW()
WHERE id=?
");

$stmt->bind_param(
    "ssssiissssssssssi",
    $title,
    $property_type,
    $location,
    $price,
    $bedrooms,
    $bathrooms,
    $garage,
    $lot_area,
    $floor_area,
    $furnishing,
    $status,
    $description,
    $amenities,
    $map_url,
    $cover_image,
    $cover_public_id,
    $id
);

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();

/* ======================================
   UPLOAD NEW GALLERY IMAGES
====================================== */

if (
    isset($_FILES['gallery_images']) &&
    !empty($_FILES['gallery_images']['name'][0])
) {

    // Get the next image order
    $result = $conn->query("
        SELECT COALESCE(MAX(image_order),0)+1 AS next_order
        FROM property_images
        WHERE property_id = $id
    ");

    $row = $result->fetch_assoc();

    $imageOrder = $row['next_order'];

    foreach ($_FILES['gallery_images']['tmp_name'] as $index => $tmpName) {

        if ($_FILES['gallery_images']['error'][$index] != 0) {
            continue;
        }

        try {

            $upload = $cloudinary->uploadApi()->upload(
                $tmpName,
                [
                    "folder" => "hopeways/properties/gallery",
                    "public_id" => "property_" . $id . "_gallery_" . $imageOrder,
                    "overwrite" => true,
                    "resource_type" => "image"
                ]
            );

            $imageUrl = $upload->offsetGet('secure_url');
            $publicId = $upload->offsetGet('public_id');

            $insert = $conn->prepare("
                INSERT INTO property_images
                (
                    property_id,
                    image_path,
                    public_id,
                    image_order
                )
                VALUES
                (
                    ?, ?, ?, ?
                )
            ");

            $insert->bind_param(
                "issi",
                $id,
                $imageUrl,
                $publicId,
                $imageOrder
            );

            if (!$insert->execute()) {
                die("Gallery Database Error: " . $insert->error);
            }

            $insert->close();

            $imageOrder++;

        } catch (Exception $e) {

            die("Gallery Upload Failed:<br>" . $e->getMessage());

        }

    }

}


/* ======================================
   DELETE REMOVED GALLERY IMAGES
====================================== */

if (!empty($_POST['deleted_images'])) {

    $deletedImages = explode(",", $_POST['deleted_images']);

    foreach ($deletedImages as $imageId) {

        $imageId = (int)$imageId;

        // Get image info
        $img = $conn->prepare("
            SELECT public_id
            FROM property_images
            WHERE id = ?
        ");

        $img->bind_param("i", $imageId);
        $img->execute();

        $result = $img->get_result();

        if ($result->num_rows > 0) {

            $image = $result->fetch_assoc();

            // Delete from Cloudinary
            if (!empty($image['public_id'])) {

                try {

                    $cloudinary->uploadApi()->destroy(
                        $image['public_id'],
                        [
                            "resource_type" => "image",
                            "invalidate" => true
                        ]
                    );

                } catch (Exception $e) {

                    // Continue even if Cloudinary fails
                }

            }

            // Delete from database
            $delete = $conn->prepare("
                DELETE FROM property_images
                WHERE id = ?
            ");

            $delete->bind_param("i", $imageId);
            $delete->execute();
            $delete->close();

        }

        $img->close();

    }

}
$conn->close();

header("Location: manage-properties.php?updated=1");
exit();