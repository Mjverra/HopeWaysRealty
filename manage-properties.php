<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "includes/db_connect.php";

/* Get all properties */

$sql = "SELECT * FROM properties ORDER BY created_at DESC";

$result = $conn->query($sql);
?>
<link rel="stylesheet" href="css/messages.css">
<link rel="stylesheet" href="css/admin.css">
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Property Management</title>

<link rel="stylesheet" href="css/messages.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<?php include "admin-header.php"; ?>

<section class="dashboard">

    <div class="dashboard-title">

        <h2>

            <i class="fas fa-house"></i>

            Property Management

        </h2>

        <a href="add-property.php" class="add-btn">

            <i class="fas fa-plus"></i>

            Add Property

        </a>

    </div>

    <div class="property-list">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

?>

<div class="property-card-admin">

    <div class="property-image">

        <?php if(!empty($row['cover_image'])){ ?>

            <img
                src="<?php echo htmlspecialchars($row['cover_image']); ?>"
                alt="Property">

        <?php }else{ ?>

            <img
                src="images/headerlogo.jpg"
                alt="No Image">

        <?php } ?>

    </div>

    <div class="property-details">

        <h3>
            <?php echo htmlspecialchars($row['title']); ?>
        </h3>

        <p>

            <i class="fas fa-location-dot"></i>

            <?php echo htmlspecialchars($row['location']); ?>

        </p>

        <p>

            <strong>Type:</strong>

            <?php echo htmlspecialchars($row['property_type']); ?>

        </p>

        <p>

            <strong>Price:</strong>

            <?php echo htmlspecialchars($row['price']); ?>

        </p>

        <p>

            <strong>Status:</strong>

            <span class="status">

                <?php echo htmlspecialchars($row['status']); ?>

            </span>

        </p>

        <div class="property-actions">

            <a
                href="edit-property.php?id=<?php echo $row['id']; ?>"
                class="btn btn-primary">

                <i class="fas fa-pen"></i>

                Edit

            </a>

            <a
                href="delete-property.php?id=<?php echo $row['id']; ?>"
                class="btn btn-danger"
                onclick="return confirm('Delete this property?');">

                <i class="fas fa-trash"></i>

                Delete

            </a>

        </div>

    </div>

</div>

<?php

    }

}else{

?>

<div class="empty-state">

    <i class="fas fa-house-circle-xmark"></i>

    <h2>No Properties Yet</h2>

    <p>Click "Add Property" to create your first listing.</p>

</div>

<?php

}

?>

    </div>

</section>

</body>

</html>