<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include "../includes/db_connect.php";

if (!isset($_GET['id'])) {
    header("Location: manage-properties.php");
    exit();
}

$id = (int) $_GET['id'];

/* ============================
   Get Property Information
============================ */

$stmt = $conn->prepare("
    SELECT
        cover_image,
        cover_public_id
    FROM properties
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: manage-properties.php");
    exit();

}

$property = $result->fetch_assoc();

$stmt->close();

/* ============================
   Delete Cover Image
============================ */

if (!empty($property['cover_public_id'])) {

    try {

        $cloudinary->uploadApi()->destroy(
            $property['cover_public_id'],
            [
                "resource_type" => "image",
                "invalidate" => true
            ]
        );

    } catch (Exception $e) {

        // Continue deleting the property
        // even if Cloudinary deletion fails.

    }

}
/* ============================
   Delete Gallery Records
============================ */

$stmt = $conn->prepare(
    "DELETE FROM property_images
     WHERE property_id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

/* ============================
   Delete Property
============================ */

$stmt = $conn->prepare(
    "DELETE FROM properties
     WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: manage-properties.php?deleted=1");
    exit();

} else {

    echo "Failed to delete property.";

}

$stmt->close();

$conn->close();