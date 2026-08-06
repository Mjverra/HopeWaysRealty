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