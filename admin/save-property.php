<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
exit();
}

include "../includes/db_connect.php";
require_once "../includes/cloudinary.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: add-property.php");
    exit();
}
/* ======================================
   GET FORM DATA
====================================== */

$title         = trim($_POST['title']);
$propertyType  = trim($_POST['property_type']);
$location      = trim($_POST['location']);
$price         = trim($_POST['price']);
$bedrooms      = (int) $_POST['bedrooms'];
$bathrooms     = (int) $_POST['bathrooms'];
$garage        = trim($_POST['garage']);
$lotArea       = trim($_POST['lot_area']);
$floorArea     = trim($_POST['floor_area']);
$furnishing    = trim($_POST['furnishing']);
$status        = trim($_POST['status']);
$description   = trim($_POST['description']);
$amenities     = trim($_POST['amenities']);
$mapUrl        = trim($_POST['map_url']);

$createdBy = $_SESSION['admin'];
/* ======================================
   VALIDATION
====================================== */

if (
    empty($title) ||
    empty($propertyType) ||
    empty($location) ||
    empty($price)
) {

    die("Please complete all required fields.");

}
/* ======================================
   INSERT PROPERTY
====================================== */

$sql = "INSERT INTO properties (

title,
property_type,
location,
price,
bedrooms,
bathrooms,
garage,
lot_area,
floor_area,
furnishing,
status,
description,
amenities,
map_url,
created_by

)

VALUES (

?,?,?,?,?,?,?,?,?,?,?,?,?,?,?

)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(

"ssssiisssssssss",

$title,
$propertyType,
$location,
$price,
$bedrooms,
$bathrooms,
$garage,
$lotArea,
$floorArea,
$furnishing,
$status,
$description,
$amenities,
$mapUrl,
$createdBy

);

if (!$stmt->execute()) {

    die("Database Error: " . $stmt->error);

}

$propertyId = $conn->insert_id;

$stmt->close();

/* ======================================
   UPLOAD COVER IMAGE TO CLOUDINARY
====================================== */

$coverImageUrl = "";

if (
    isset($_FILES['cover_image']) &&
    $_FILES['cover_image']['error'] == 0
) {

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    $extension = strtolower(pathinfo(
        $_FILES['cover_image']['name'],
        PATHINFO_EXTENSION
    ));

    if (!in_array($extension, $allowedExtensions)) {
        die("Invalid cover image format.");
    }

    if ($_FILES['cover_image']['size'] > 10 * 1024 * 1024) {
        die("Cover image exceeds the 10MB limit.");
    }

    $mime = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (strpos($mime, "image/") !== 0) {
        die("Invalid image file.");
    }

    try {

        $upload = $cloudinary->uploadApi()->upload(
            $_FILES['cover_image']['tmp_name'],
            [
                "folder" => "hopeways/properties",
                "public_id" => "property_" . $propertyId . "_cover",
                "overwrite" => true,
                "resource_type" => "image"
            ]
        );

        $coverImageUrl = $upload->offsetGet('secure_url');
        
        echo $coverImageUrl;
die();

    } catch (Exception $e) {

        die("Cloudinary Upload Failed:<br>" . $e->getMessage());

    }

}
/* ======================================
   UPDATE COVER IMAGE
====================================== */

$update = $conn->prepare("
    UPDATE properties
    SET cover_image = ?
    WHERE id = ?
");

$update->bind_param(
    "si",
    $coverImageUrl,
    $propertyId
);

if (!$update->execute()) {
    die("Database Error: " . $update->error);
}

$update->close();

$conn->close();

header("Location: manage-properties.php?success=1");
exit();