<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

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
/* ==============================
   PROPERTY FOLDER
============================== */

$propertyFolder = "../uploads/properties/property-" . $id . "/";

if (!is_dir($propertyFolder)) {
    mkdir($propertyFolder, 0777, true);
}

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

    if ($_FILES['cover_image']['size'] > 5 * 1024 * 1024) {
        die("Cover image exceeds 5MB.");
    }

    $mime = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (strpos($mime, "image/") !== 0) {
        die("Invalid image.");
    }

    $coverFile = "cover." . $extension;

    $coverImagePath = $propertyFolder . $coverFile;

    if (
        move_uploaded_file(
            $_FILES['cover_image']['tmp_name'],
            $coverImagePath
        )
    ) {

        // Save relative path into database
        $cover_image = "uploads/properties/property-" . $id . "/" . $coverFile;
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
    updated_at=NOW()
WHERE id=?
");

$stmt->bind_param(
    "ssssiisssssssssi",
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
    $id
);

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();
header("Location: manage-properties.php?updated=1");
exit();