<?php

include "includes/db_connect.php";

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Services | Hope Ways Realty Brokerage</title>

  <link rel="stylesheet" href="css/styleS.css" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
  <header>
    <nav>
      <div class="logo">
        <a href="index.php">
          <img
            src="images/headerlogo.jpg"
            class="header-logo"
            alt="Hope Ways Realty" />

          <span>HopeWays Realty</span>
        </a>
      </div>

      <ul>
        <li><a href="index.php">Home</a></li>

        <li><a href="properties.php">Properties</a></li>

        <li><a href="about.php">About</a></li>

        <li>
          <a href="services.php" class="active">Services</a>
        </li>

        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>
  <section class="services-hero">
    <div class="overlay">
      <h1>Our Services</h1>

      <p>
        Professional Real Estate Solutions for Buying, Selling, Leasing, and
        Investing.
      </p>

      <a href="properties.php" class="btn"> Browse Properties </a>
    </div>
  </section>
  <section class="services-intro">
    <h2>Helping You Achieve Your Real Estate Goals</h2>

    <p>
      Hope Ways Realty Brokerage offers complete real estate services with
      honesty, professionalism, and personalized assistance.
    </p>
  </section>

  <!-- ================= OUR SERVICES ================= -->

  <section class="services">
    <div class="section-title">
      <h2>Our Services</h2>

      <p>
        We provide professional real estate services designed to help buyers,
        sellers, landlords, tenants, and investors achieve their goals.
      </p>
    </div>

    <div class="services-grid">
      <!-- Service 1 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-home"></i>
        </div>

        <h3>Property Buying</h3>

        <p>
          Helping clients find residential, commercial, and investment
          properties that match their needs, budget, and lifestyle.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- Service 2 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-key"></i>
        </div>

        <h3>Property Selling</h3>

        <p>
          Professional marketing strategies to help property owners sell
          faster and at the best possible price.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- Service 3 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-building"></i>
        </div>

        <h3>Property Leasing</h3>

        <p>
          Residential and commercial leasing services for both property owners
          and prospective tenants.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- Service 4 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-chart-line"></i>
        </div>

        <h3>Investment Consultation</h3>

        <p>
          Expert advice to help clients make informed and profitable real
          estate investment decisions.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- Service 5 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-file-signature"></i>
        </div>

        <h3>Documentation Assistance</h3>

        <p>
          Assistance with contracts, title transfers, legal documents, and
          other property transaction requirements.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <!-- Service 6 -->

      <div class="service-card">
        <div class="service-icon">
          <i class="fas fa-users"></i>
        </div>

        <h3>Property Management</h3>

        <p>
          Comprehensive property management services, including tenant
          coordination and property maintenance.
        </p>

        <a href="contact.php" class="service-btn">
          Learn More <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>
  <section class="why-us">
    <h2>Why Choose Hope Ways Realty?</h2>

    <div class="why-grid">
      <div class="why-card">
        <i class="fas fa-check-circle"></i>

        <h3>Licensed Professionals</h3>
      </div>

      <div class="why-card">
        <i class="fas fa-check-circle"></i>

        <h3>Trusted Service</h3>
      </div>

      <div class="why-card">
        <i class="fas fa-check-circle"></i>

        <h3>Local Market Experts</h3>
      </div>

      <div class="why-card">
        <i class="fas fa-check-circle"></i>

        <h3>Excellent Customer Support</h3>
      </div>
    </div>
  </section>
  <section class="process">
    <h2>Our Process</h2>

    <div class="process-grid">
      <div class="process-card">
        <span>1</span>

        <h3>Consultation</h3>
      </div>

      <div class="process-card">
        <span>2</span>

        <h3>Property Viewing</h3>
      </div>

      <div class="process-card">
        <span>3</span>

        <h3>Documentation</h3>
      </div>

      <div class="process-card">
        <span>4</span>

        <h3>Closing</h3>
      </div>
    </div>
  </section>
  <!-- ================= TESTIMONIALS ================= -->

  <section class="testimonials">
    <div class="section-title">
      <h2>What Our Clients Say</h2>

      <p>
        We are committed to providing exceptional real estate service and
        helping our clients achieve their property goals.
      </p>
    </div>

    <div class="testimonial-grid">
      <!-- Testimonial 1 -->

      <div class="testimonial-card">
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>

        <p class="testimonial-text">
          "Hope Ways Realty Brokerage made buying our dream home stress-free.
          Their team guided us every step of the way."
        </p>

        <div class="client-icon">
          <i class="fas fa-user"></i>

          <div>
            <h6>Maria Santos</h6>
            <span>Home Buyer</span>
          </div>
        </div>
      </div>

      <!-- Testimonial 2 -->

      <div class="testimonial-card">
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>

        <p class="testimonial-text">
          "Very professional and responsive. They helped us sell our property
          quickly at an excellent price."
        </p>

        <div class="client-icon">
          <i class="fas fa-user"></i>

          <div>
            <h6>John Dela Cruz</h6>
            <span>Property Seller</span>
          </div>
        </div>
      </div>

      <!-- Testimonial 3 -->

      <div class="testimonial-card">
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>

        <p class="testimonial-text">
          "Excellent customer service from beginning to end. Highly
          recommended for anyone looking for a trusted real estate partner."
        </p>

        <div class="client-icon">
          <i class="fas fa-user"></i>

          <div>
            <h6>Rose Garcia</h6>
            <span>Property Investor</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="cta">
    <h2>Ready to Find Your Dream Property?</h2>

    <p>Contact Hope Ways Realty Brokerage today.</p>

    <a href="contact.php" class="btn"> Contact Us </a>
  </section>
  <footer>
    <div class="footer-content">
      <h3>Hope Ways Realty Brokerage</h3>

      <p>Your trusted partner in real estate.</p>

      <p>© 2026 Hope Ways Realty Brokerage</p>
    </div>
  </footer>
</body>

</html>