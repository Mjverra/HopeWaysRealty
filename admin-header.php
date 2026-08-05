<header class="top-header">

    <div class="header-content">

        <div>

            <h1>
                <i class="fas fa-user-shield"></i>
                HopeWays Realty Admin
            </h1>

            <p>
                Welcome,
                <strong><?php echo $_SESSION['admin']; ?></strong>
            </p>

        </div>

       <div class="header-actions">

    <a href="admin-dashboard.php"
       class="nav-btn <?php echo basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-gauge-high"></i>
        Dashboard
    </a>

    <a href="view-messages.php"
       class="nav-btn <?php echo basename($_SERVER['PHP_SELF']) == 'view-messages.php' ? 'active' : ''; ?>">
        <i class="fas fa-envelope"></i>
        Messages
    </a>

    <a href="manage-properties.php"
       class="nav-btn <?php echo basename($_SERVER['PHP_SELF']) == 'manage-properties.php' ? 'active' : ''; ?>">
        <i class="fas fa-house"></i>
        Properties
    </a>

    <a href="logout.php" class="logout-btn">
        <i class="fas fa-right-from-bracket"></i>
        Logout
    </a>

</div>

    </div>

</header>