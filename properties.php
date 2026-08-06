<?php

include "includes/db_connect.php";

$sql = "SELECT * FROM properties
        ORDER BY created_at DESC";

$result = $conn->query($sql);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Featured Properties | Hope Ways Realty</title>

    <link rel="stylesheet" href="css/style.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
  </head>

  <body>
    <!-- ================= HEADER ================= -->

   <header>
    <nav>

        <div class="logo">
            <a href="index.php">
                <img
                    src="images/headerlogo.jpg"
                    class="header-logo"
                    alt="Hope Ways Realty">

                <span>HopeWays Realty</span>
            </a>
        </div>

        <ul>

            <li>
                <a href="index.php">Home</a>
            </li>

            <li>
                <a href="properties.php" class="active">Properties</a>
            </li>

            <li>
                <a href="about.php">About</a>
            </li>

            <li>
                <a href="services.php">Services</a>
            </li>

            <li>
                <a href="contact.php">Contact</a>
            </li>

        </ul>

    </nav>
</header>

    <!-- ================= HERO ================= -->
    <section class="properties-hero">
      <!-- Background Video -->
      <video class="hero-video" autoplay muted loop playsinline>
        <source src="images/property1.mp4" type="video/mp4" />
        Your browser does not support the video tag.
      </video>

      <!-- Dark Overlay -->
      <div class="overlay">
        <h1>Featured Properties</h1>

        <p>Discover quality homes and investment opportunities.</p>

        <a href="#properties" class="btn">Browse Listings</a>
      </div>
    </section>

    <!-- ================= PROPERTIES ================= -->

    <section id="properties" class="properties">
      <h2>Our Featured Listings</h2>

      <p class="subtitle">
        Choose from our latest residential and commercial properties.
      </p>

      <div class="property-container">

<?php if($result->num_rows > 0){ ?>

<?php while($row = $result->fetch_assoc()){ ?>

<div class="property-card">

    <img
        src="<?php echo htmlspecialchars($row['cover_image']); ?>"
        alt="<?php echo htmlspecialchars($row['title']); ?>">

    <div class="property-info">

        <h3>
            <?php echo htmlspecialchars($row['title']); ?>
        </h3>

        <p>
            <i class="fas fa-map-marker-alt"></i>
            <strong>
                <?php echo htmlspecialchars($row['location']); ?>
            </strong>
        </p>

        <p>

            <?php

            $description = strip_tags($row['description']);

            if(strlen($description) > 120){
                echo htmlspecialchars(substr($description,0,120)) . "...";
            } else {
                echo htmlspecialchars($description);
            }

            ?>

        </p>

        <h4>

            ₱<?php echo number_format((float)$row['price'], 2); ?>

        </h4>

        <a
            href="property.php?id=<?php echo $row['id']; ?>"
            class="btn">

            View More Details

        </a>

    </div>

</div>

<?php } ?>

<?php } else { ?>

<div class="empty-state">

    <i class="fas fa-house-circle-xmark"></i>

    <h2>No Properties Available</h2>

    <p>Please check back later for new listings.</p>

</div>

<?php } ?>

</div>
    </section>

    <!-- ================= CTA ================= -->

    <section class="cta">
      <h2>Looking for Your Dream Property?</h2>

      <p>
        Our experienced brokers are ready to help you find the perfect home.
      </p>

      <a href="contact.php" class="btn"> Contact Us </a>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer>
      <div class="footer-content">
        <h3>Hope Ways Realty Brokerage</h3>

        <p>Your Trusted Partner in Real Estate</p>

        <hr />

        <p>
          <strong>Doris Hope S. Maruya, REB, REA</strong><br />
          Real Estate Broker<br />
          PRC Reg. No. 0036399
        </p>

        <p>
          <strong>Rose Windel B. Verra</strong><br />
          Registered Real Estate Salesperson
        </p>

        <p>
          <strong>Marc Jundel B. Verra</strong><br />
          Registered Real Estate Salesperson
        </p>

        <hr />

        <p>
          <strong>DHUD Registration No.</strong><br />
          R8-B-05/26-80074
        </p>

        <p>
          <i class="fas fa-phone"></i>
          <a href="tel:+639976055096">+63 997 605 5096</a> |
          <a href="tel:+639524833739">+63 952 483 3739</a>
        </p>

        <p>
          <i class="fas fa-envelope"></i>
          <a href="mailto:hopewaysrealtybrokerage@gmail.com">
            hopewaysrealtybrokerage@gmail.com
          </a>
        </p>

        <p>
          <i class="fab fa-facebook"></i>
          Follow us on Facebook:
          <a
            href="https://www.facebook.com/share/14jEXvByckw/?mibextid=wwXlfr"
            target="_blank"
            rel="noopener noreferrer"
          >
            Hope Ways Realty
          </a>
        </p>

        <p>&copy; 2026 Hope Ways Realty Brokerage. All Rights Reserved.</p>
      </div>
    </footer>
  </body>
</html>
