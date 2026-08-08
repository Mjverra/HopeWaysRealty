<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
exit();
}

include "../includes/db_connect.php";

/* Get all properties */

$search = trim($_GET['search'] ?? '');

if ($search != "") {

    $sql = "
        SELECT *
        FROM properties
        WHERE
            title LIKE ?
            OR location LIKE ?
            OR property_type LIKE ?
            OR status LIKE ?
        ORDER BY id DESC
    ";

    $stmt = $conn->prepare($sql);

    $keyword = "%" . $search . "%";

    $stmt->bind_param(
        "ssss",
        $keyword,
        $keyword,
        $keyword,
        $keyword
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query("
        SELECT *
        FROM properties
        ORDER BY id DESC
    ");

}
?>
<link rel="stylesheet" href="../css/messages.css">
<link rel="stylesheet" href="../css/admin.css">
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
<?php if(isset($_GET['deleted'])){ ?>

<div class="success-message">

    <i class="fas fa-circle-check"></i>

    Property deleted successfully.

</div>

<?php } ?>

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
<div class="search-bar">

    <form method="GET">

        <input
            type="text"
            name="search"
            placeholder="Search by title, location, type or status..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
<select name="status">

    <option value="">All Status</option>

    <option value="Available"
        <?= (($_GET['status'] ?? '') == 'Available') ? 'selected' : '' ?>>
        Available
    </option>

    <option value="Reserved"
        <?= (($_GET['status'] ?? '') == 'Reserved') ? 'selected' : '' ?>>
        Reserved
    </option>

    <option value="Sold"
        <?= (($_GET['status'] ?? '') == 'Sold') ? 'selected' : '' ?>>
        Sold
    </option>

</select>

<select name="type">

    <option value="">All Types</option>

    <option value="House & Lot"
        <?= (($_GET['type'] ?? '') == 'House & Lot') ? 'selected' : '' ?>>
        House & Lot
    </option>

    <option value="Townhouse"
        <?= (($_GET['type'] ?? '') == 'Townhouse') ? 'selected' : '' ?>>
        Townhouse
    </option>

    <option value="Residential Lot"
        <?= (($_GET['type'] ?? '') == 'Residential Lot') ? 'selected' : '' ?>>
        Residential Lot
    </option>

    <option value="Commercial Lot"
        <?= (($_GET['type'] ?? '') == 'Commercial Lot') ? 'selected' : '' ?>>
        Commercial Lot
    </option>

    <option value="Agricultural Land"
        <?= (($_GET['type'] ?? '') == 'Agricultural Land') ? 'selected' : '' ?>>
        Agricultural Land
    </option>

    <option value="Condominium"
        <?= (($_GET['type'] ?? '') == 'Condominium') ? 'selected' : '' ?>>
        Condominium
    </option>

    <option value="Office Space"
        <?= (($_GET['type'] ?? '') == 'Office Space') ? 'selected' : '' ?>>
        Office Space
    </option>

    <option value="Warehouse"
        <?= (($_GET['type'] ?? '') == 'Warehouse') ? 'selected' : '' ?>>
        Warehouse
    </option>

</select>
        <button type="submit" class="btn btn-primary">

            <i class="fas fa-search"></i>

            Search

        </button>

        <?php if (!empty($_GET['search'])): ?>

            <a href="manage-properties.php" class="btn btn-secondary">

                <i class="fas fa-times"></i>

                Clear

            </a>

        <?php endif; ?>

    </form>

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
    onclick="return confirm('Are you sure you want to permanently delete this property?\n\nThis will also delete:\n• Cover Image\n• Gallery Images\n• Property Details');">

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