<header class="admin-header">

    <div class="admin-header-left">

        <h2>
            <i class="fas fa-building"></i>
            HopeWays Realty
        </h2>

        <span class="admin-subtitle">
            Administration Panel
        </span>

    </div>

    <nav class="admin-nav">

        <a href="admin-dashboard.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php' ? 'active' : '' ?>">

            <i class="fas fa-chart-line"></i>
            Dashboard

        </a>

        <a href="manage-properties.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'manage-properties.php' ? 'active' : '' ?>">

            <i class="fas fa-house"></i>
            Properties

        </a>

        <a href="view-messages.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'view-messages.php' ? 'active' : '' ?>">

            <i class="fas fa-envelope"></i>
            Messages

        </a>

        <?php if ($_SESSION['role'] == "Super Admin"): ?>

            <a href="manage-admins.php"
                class="nav-btn <?= basename($_SERVER['PHP_SELF']) == 'manage-admins.php' ? 'active' : '' ?>">

                <i class="fas fa-users-cog"></i>
                Admins

            </a>

        <?php endif; ?>

    </nav>

    <div class="admin-user">

        <div>

            <strong><?= htmlspecialchars($_SESSION['admin']) ?></strong>

            <br>

            <small>Super Administrator</small>

        </div>

        <a href="../logout.php" class="logout-btn">

            <i class="fas fa-right-from-bracket"></i>

            Logout

        </a>

    </div>

</header>