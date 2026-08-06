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
    updated_at=NOW()
WHERE id=?
");

$stmt->bind_param(
    "ssssiissssssssi",
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
    $id
);

if (!$stmt->execute()) {
    die("Database Error: " . $stmt->error);
}

$stmt->close();
header("Location: manage-properties.php?updated=1");
exit();