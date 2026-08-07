<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";
require_once "../includes/cloudinary.php";
if (!isset($_GET['id']) || !isset($_GET['property'])) {

    die("Invalid request.");

}

$imageId = (int) $_GET['id'];
$propertyId = (int) $_GET['property'];
/* ======================================
   GET IMAGE INFORMATION
====================================== */

$stmt = $conn->prepare("
    SELECT *
    FROM property_images
    WHERE id = ?
");

$stmt->bind_param("i", $imageId);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    die("Image not found.");

}

$image = $result->fetch_assoc();

$stmt->close();
/* ======================================
   DELETE FROM CLOUDINARY
====================================== */

try {

    if (!empty($image['public_id'])) {

        $cloudinary->uploadApi()->destroy(
            $image['public_id']
        );

    }

} catch (Exception $e) {

    die("Cloudinary Delete Failed:<br>" . $e->getMessage());

}
/* ======================================
   DELETE DATABASE RECORD
====================================== */

$stmt = $conn->prepare("
    DELETE FROM property_images
    WHERE id = ?
");

$stmt->bind_param(
    "i",
    $imageId
);

$stmt->execute();

$stmt->close();
$conn->close();
header("Location: edit-property.php?id=" . $propertyId);
exit();