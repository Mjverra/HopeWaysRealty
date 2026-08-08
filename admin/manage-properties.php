<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
exit();
}

include "../includes/db_connect.php";
/* ======================================
   PROPERTY STATISTICS
====================================== */





/* Get all properties */

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');
$type   = trim($_GET['type'] ?? '');
/* ===============================
   PAGINATION
================================ */

$limit = 10;

$page = isset($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM properties WHERE 1=1";

$params = [];
$types = "";
/* ===============================
   COUNT FILTERED RESULTS
================================ */

$countSql = str_replace(
    "SELECT *",
    "SELECT COUNT(*) AS total",
    $sql
);

$countStmt = $conn->prepare($countSql);

if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}

$countStmt->execute();

$totalRows = $countStmt
    ->get_result()
    ->fetch_assoc()['total'];

$countStmt->close();

$totalPages = ceil($totalRows / $limit);

/* ===============================
   SEARCH
================================ */

if ($search != "") {

    $sql .= " AND (
        title LIKE ?
        OR location LIKE ?
        OR property_type LIKE ?
        OR status LIKE ?
    )";

    $keyword = "%" . $search . "%";

    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;

    $types .= "ssss";
}

/* ===============================
   STATUS FILTER
================================ */

if ($status != "") {

    $sql .= " AND status = ?";

    $params[] = $status;

    $types .= "s";
}

/* ===============================
   PROPERTY TYPE FILTER
================================ */

if ($type != "") {

    $sql .= " AND property_type = ?";

    $params[] = $type;

    $types .= "s";
}

/* ======================================
   PROPERTY STATISTICS
====================================== */

$statsSql = str_replace(
    "SELECT *",
    "SELECT status",
    $sql
);

$statsStmt = $conn->prepare($statsSql);

if (!empty($params)) {
    $statsStmt->bind_param($types, ...$params);
}

$statsStmt->execute();

$statsResult = $statsStmt->get_result();

$totalProperties = 0;
$availableProperties = 0;
$reservedProperties = 0;
$soldProperties = 0;

while ($row = $statsResult->fetch_assoc()) {

    $totalProperties++;

    switch ($row['status']) {

        case "Available":
            $availableProperties++;
            break;

        case "Reserved":
            $reservedProperties++;
            break;

        case "Sold":
            $soldProperties++;
            break;

    }

}

$statsStmt->close();

/* ======================================
   LOAD PROPERTY LIST
====================================== */
$sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

$params[] = $limit;
$params[] = $offset;

$types .= "ii";

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();




?>
<link rel="stylesheet" href="../css/messages.css">
<link rel="stylesheet" href="../css/admin.css">
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Property Management</title>



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
    <div class="stats-grid">

    <div class="stat-card">
        <i class="fas fa-house"></i>
        <h3><?= $totalProperties ?></h3>
        <p>Total Properties</p>
    </div>

    <div class="stat-card available">
        <i class="fas fa-circle-check"></i>
        <h3><?= $availableProperties ?></h3>
        <p>Available</p>
    </div>

    <div class="stat-card reserved">
        <i class="fas fa-clock"></i>
        <h3><?= $reservedProperties ?></h3>
        <p>Reserved</p>
    </div>

    <div class="stat-card sold">
        <i class="fas fa-circle-xmark"></i>
        <h3><?= $soldProperties ?></h3>
        <p>Sold</p>
    </div>

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

        <?php if (
            !empty($_GET['search']) ||
            !empty($_GET['status']) ||
            !empty($_GET['type'])
        ): ?>

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



<?php if ($totalPages > 1): ?>

<div class="pagination">

    <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>&type=<?= urlencode($type) ?>">
            &laquo; Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

        <a
            href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>&type=<?= urlencode($type) ?>"
            class="<?= ($i == $page) ? 'active' : '' ?>">

            <?= $i ?>

        </a>

    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>

        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status) ?>&type=<?= urlencode($type) ?>">
            Next &raquo;
        </a>

    <?php endif; ?>

</div>

<?php endif; ?>

</section>

</body>

</html>