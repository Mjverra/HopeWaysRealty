<?php

include "includes/db_connect.php";

/* ======================================
   GET PROPERTY ID
====================================== */

if (!isset($_GET['id'])) {

    die("Property not found.");

}

$id = (int)$_GET['id'];

/* ======================================
   GET PROPERTY
====================================== */

$sql = "SELECT *
        FROM properties
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    die("Property not found.");

}

$property = $result->fetch_assoc();

/* ======================================
   GET PROPERTY GALLERY
====================================== */

$sqlGallery = "SELECT *
               FROM property_images
               WHERE property_id = ?
               ORDER BY id ASC";

$stmtGallery = $conn->prepare($sqlGallery);

$stmtGallery->bind_param("i", $id);

$stmtGallery->execute();

$gallery = $stmtGallery->get_result();

?>

