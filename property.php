<?php

include "includes/db_connect.php";

if (!isset($_GET['id'])) {

    header("Location: properties.php");
    exit();

}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT *
    FROM properties
    WHERE id=?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: properties.php");
    exit();

}

$property = $result->fetch_assoc();

$stmt->close();
?>
<?php

$gallery = [];

$stmt = $conn->prepare("
    SELECT *
    FROM property_images
    WHERE property_id=?
    ORDER BY image_order ASC
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_assoc()){

    $gallery[] = $row;

}

$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

<?php echo htmlspecialchars($property['title']); ?>

</title>

<link
rel="stylesheet"
href="css/style.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include "includes/navigation.php"; ?>
<section class="property-hero">

<img
src="<?php echo htmlspecialchars($property['cover_image']); ?>"
alt="<?php echo htmlspecialchars($property['title']); ?>">

</section>
<section class="property-details">

<h1>

<?php echo htmlspecialchars($property['title']); ?>

</h1>

<h2>

₱<?php echo number_format((float)$property['price'],2); ?>

</h2>

<p>

<i class="fas fa-location-dot"></i>

<?php echo htmlspecialchars($property['location']); ?>

</p>

</section>