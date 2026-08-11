<?php

include "includes/db_connect.php";

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | Hope Ways Realty Brokerage</title>

  <link rel="stylesheet" href="css/styleA.css" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
  <!-- HEADER -->

  <header>
    <nav>
      <div class="logo">
        <a href="index.php">
          <img
            src="images/logo/headerlogo.jpg"
            alt="Hope Ways Realty Logo"
            class="header-logo" />

          <span>HopeWays Realty</span>
        </a>
      </div>

      <ul>
        <li><a href="index.php">Home</a></li>

        <li><a href="properties.php">Properties</a></li>

        <li>
          <a href="about.php" class="active">About</a>
        </li>

        <li><a href="services.php">Services</a></li>

        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- HERO -->

  <section class="hero-small">
    <div class="hero-content">
      <h1>About Hope Ways Realty Brokerage</h1>

      <p>
        Helping individuals and families find the perfect property with
        honesty, professionalism, and excellence.
      </p>
    </div>
  </section>

  <!-- COMPANY PROFILE -->

  <section class="about-section">
    <div class="container">
      <h2>Who We Are</h2>

      <p>
        Hope Ways Realty Brokerage is a trusted real estate company committed
        to helping clients buy, sell, and invest in quality residential and
        commercial properties throughout the Philippines. Our goal is to
        provide exceptional customer service while making every real estate
        transaction smooth, transparent, and rewarding.
      </p>

      <p>
        Whether you are a first-time homebuyer, an experienced investor, or
        planning to sell your property, our team is dedicated to providing
        expert guidance every step of the way.
      </p>
    </div>
  </section>

  <!-- MISSION & VISION -->

  <section class="mission-vision">
    <div class="mission">
      <i class="fas fa-bullseye"></i>

      <h2>Our Mission</h2>

      <p>
        To deliver professional real estate services that exceed client
        expectations by providing quality property solutions, expert advice,
        and outstanding customer care.
      </p>
    </div>

    <div class="vision">
      <i class="fas fa-eye"></i>

      <h2>Our Vision</h2>

      <p>
        To become one of the most trusted and respected real estate brokerages
        in the Philippines, helping families achieve their dream of property
        ownership.
      </p>
    </div>
  </section>

  <!-- CORE VALUES -->

  <section class="values">
    <h2>Our Core Values</h2>

    <div class="value-container">
      <div class="value-card">
        <i class="fas fa-handshake"></i>

        <h3>Integrity</h3>

        <p>
          We conduct every transaction with honesty, transparency, and
          professionalism.
        </p>
      </div>

      <div class="value-card">
        <i class="fas fa-users"></i>

        <h3>Customer Commitment</h3>

        <p>
          Our clients always come first, and we strive to deliver excellent
          service.
        </p>
      </div>

      <div class="value-card">
        <i class="fas fa-award"></i>

        <h3>Excellence</h3>

        <p>
          We continuously improve our services to provide the best real estate
          experience.
        </p>
      </div>
    </div>
  </section>

  <!-- WHY CHOOSE US -->

  <section class="why-us">
    <h2>Why Choose Hope Ways Realty?</h2>

    <div class="features">
      <div class="feature">
        <i class="fas fa-house"></i>

        <h3>Quality Listings</h3>

        <p>
          Carefully selected residential, commercial, and investment
          properties.
        </p>
      </div>

      <div class="feature">
        <i class="fas fa-user-tie"></i>

        <h3>Experienced Brokers</h3>

        <p>
          Knowledgeable professionals ready to assist throughout your property
          journey.
        </p>
      </div>

      <div class="feature">
        <i class="fas fa-location-dot"></i>

        <h3>Prime Locations</h3>

        <p>Properties located in growing and highly desirable communities.</p>
      </div>
    </div>
  </section>

  <!-- TEAM -->

  <section class="team">
    <h2>Meet Our Team</h2>

    <div class="team-container">
      <div class="team-card">
        <img src="images/agent.jpg" alt="Broker" />

        <h3>Doris Hope Maruya, REA, REB</h3>

        <p><b> Licensed Real Estate Appraiser & Broker</b><br>PRC License No. : 0036399 <br>DHSUD Registration No. : R8-B-05/26-80074</p>
      </div>

      <div class="team-card">
        <img src="images/agent.jpg" alt="Real Estate Salesperson" />

        <h3>Rose Windel B. Verra</h3>

        <p>Real Estate Salesperson</p>
      </div>

      <div class="team-card">
        <img src="images/agent.jpg" alt="Real Estate Salesperson" />

        <h3>Marc Jundel B. Verra</h3>

        <p>Real Estate Salesperson</p>
      </div>
    </div>
  </section>

  <!-- CALL TO ACTION -->

  <section class="cta">
    <h2>Let's Find Your Dream Property</h2>

    <p>Explore our available listings or contact our team today.</p>

    <a href="properties.php" class="btn"> View Properties </a>
  </section>

  <!-- FOOTER -->

  <footer>
    <p>© 2026 Hope Ways Realty Brokerage. All Rights Reserved.</p>
  </footer>
</body>

</html>