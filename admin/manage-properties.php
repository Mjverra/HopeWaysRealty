<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "db_connect.php";

/* Get all properties */

$sql = "SELECT * FROM properties ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

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

<!-- property card goes here -->

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