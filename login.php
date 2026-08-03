<link rel="stylesheet" href="css/login.css">
<div class="login-container">

    <img
        src="images/headerlogo.jpg"
        alt="Hope Ways Realty Logo"
        class="login-logo"
    >

    <h1>Administrator Login</h1>

    <p>Please enter your username and password.</p>

    <form action="login-process.php" method="POST">

        <div class="input-group">
            <i class="fas fa-user"></i>

            <input
                type="text"
                name="username"
                placeholder="Username"
                required
            >
        </div> <br>

        <div class="input-group">
            <i class="fas fa-lock"></i>

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >
        </div> <br>

        <button type="submit">
            <i class="fas fa-right-to-bracket"></i>
            Login
        </button>

    </form><br>

    <a href="index.html" class="back-home">
        <i class="fas fa-house"></i>
        Back to Home
    </a>

</div>