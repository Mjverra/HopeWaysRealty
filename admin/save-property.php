<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../includes/db_connect.php";

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
   CREATE PROPERTY FOLDER
====================================== */

$propertyFolder = __DIR__ . "/uploads/properties/" . $propertyId . "/";

if (!is_dir($propertyFolder)) {

    mkdir($propertyFolder, 0777, true);

}
/* ======================================
   UPLOAD COVER IMAGE
====================================== */

$coverImagePath = "";

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

    if ($_FILES['cover_image']['size'] > 5 * 1024 * 1024) {

        die("Cover image exceeds the 5MB limit.");

    }

    $mime = mime_content_type($_FILES['cover_image']['tmp_name']);

    if (strpos($mime, "image/") !== 0) {

        die("Invalid image file.");

    }

    $coverFile = "cover." . $extension;

$coverImagePath = $propertyFolder . $coverFile;

    if (!move_uploaded_file(
    $_FILES['cover_image']['tmp_name'],
    $coverImagePath
)) {

    echo "<h2>UPLOAD FAILED</h2>";

    echo "<pre>";
    print_r($_FILES['cover_image']);
    echo "</pre>";

    echo "<p><strong>Destination:</strong> " . $coverImagePath . "</p>";

    echo "<p><strong>Folder Exists:</strong> ";
    var_dump(is_dir($propertyFolder));
    echo "</p>";

    echo "<p><strong>Folder Writable:</strong> ";
    var_dump(is_writable($propertyFolder));
    echo "</p>";

    die();
}

}
/* ======================================
   UPDATE COVER IMAGE
====================================== */

$update = $conn->prepare(
    "UPDATE properties
     SET cover_image = ?
     WHERE id = ?"
);

$dbImagePath = "uploads/properties/" . $propertyId . "/" . $coverFile;

$update->bind_param(
    "si",
    $dbImagePath,
    $propertyId
);
$update->execute();

$update->close();
$conn->close();

header("Location: admin/manage-properties.php?success=1");
exit();