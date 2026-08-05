<?php
include "includes/db_connect.php";

$count = 0;

// Count only unread messages
$sql = "SELECT COUNT(*) AS total
        FROM contact_messages
        WHERE is_read = 0";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $count = $row['total'];
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Hope Ways Realty Brokerage</title>

    <link rel="stylesheet" href="css/style.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
  </head>

  <body>
    <header>
      <nav>
        <div class="logo">
          <a href="index.php">
            <img src="images/headerlogo.jpg" class="header-logo" />

            <span>HopeWays Realty</span>
          </a>
        </div>

       <ul>
    <li><a href="index.php">Home</a></li>

    <li><a href="properties.html">Properties</a></li>

    <li><a href="about.html">About</a></li>

    <li><a href="services.html">Services</a></li>

    <li><a href="contact.html">Contact</a></li>

    <li class="admin-nav">
    <a href="admin/view-messages.php" class="admin-link">
        <u>| Admin Access |</u>
    </a>

    <a href="admin/view-messages.php" class="notification-badge">
    🔔 <span id="messageCount"><?php echo $count; ?></span>
</a>
</li>
</ul>
      </nav>
    </header>

    <section class="hero">
      <div class="hero-overlay">
        <div class="hero-content">
          <h1>Find Your Dream Properties Today</h1>

          <p>
            Helping families and investors discover quality homes, lots,
            condominiums and commercial properties throughout the Philippines.
          </p>

          <div class="hero-buttons">
            <a href="properties.html" class="btn-primary">
              Browse Properties
            </a>

            <a href="contact.html" class="btn-secondary"> Contact Us </a>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
