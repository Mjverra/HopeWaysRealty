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
