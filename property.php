<?php
include "includes/db_connect.php";

// Check if property ID exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: properties.php");
    exit();
}

$id = (int)$_GET['id'];

// Get property information
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: properties.php");
    exit();
}

$property = $result->fetch_assoc();

$stmt->close();

// Get gallery images
$stmt = $conn->prepare("
    SELECT *
    FROM property_images
    WHERE property_id = ?
    ORDER BY id ASC
");

$stmt->bind_param("i", $id);
$stmt->execute();

$gallery = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
<?= htmlspecialchars($property['title']) ?>
</title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/property.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<h1>HEADER TEST</h1>



<h1>FOOTER TEST</h1>

</body>

</html>