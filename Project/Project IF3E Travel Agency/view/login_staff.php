<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff - Sheep's Travel</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="../styles/login_staff.css">
</head>
<body>

<!-- Menu de navigation -->
<header>
    <div class="nav-container">
        <div class="logo">
            <img src="../pictures/Sheep%20Travel%20Agency%20Logo.png" alt="Image 0">
            <h1>Sheep's Travel</h1>

        </div>
        <nav>
            <ul>
                <li><a href="menu_client.php" class="protected-link">Home</a></li>
                <li><a href="booking.php" class="protected-link">Booking</a></li>
                <li><a href="loyalty.php" class="protected-link">Loyalty</a></li>
                <li><a href="client_history_reservation.php" class="protected-link">History</a></li>
                <li><a href="feedback.php" class="protected-link">Feedback</a></li>
                <li><a href="contact_us.php" class="protected-link">Contact</a></li>
            </ul>
        </nav>
        <?php
        session_start();
        ?>

        <div class="login-signup" style="...">
            <?php if (!isset($_SESSION["first_name"])): ?>
                <a href="../view/login_client.php">Login</a> | <a href="../view/signup.php">Signup</a>
            <?php else: ?>
                <!-- Si l'utilisateur est connecté, afficher un message de bienvenue et un bouton de déconnexion -->
                <span>Welcome, <?php echo $_SESSION["first_name"]; ?></span>
                <a href="../controller/signout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="header">
    <h1 class="login-title">Login Staff</h1>
</div>

<form method="post" action="../controller/login_staff.php" id="loginForm">
    <label>
        Email :
        <input type="text" name="email" spellcheck="false" placeholder="abc.def@utbm.fr" title="Please enter your email" required="required"/>
    </label>
    <br/>
    <label>
        Mot de passe :
        <input type="password" name="password" />
    </label>
    <br/>

    <!-- Bouton pour changer entre Client et Staff -->
    <a href="login_client.php" class="toggle-button">Client</a>

    <input type="submit" value="Connexion"/>
</form>


<!-- Lien vers la page d'inscription -->
<p class="signup-link" style="text-align: center;">
    <small>Pas encore de compte ? <a href="signup.php">Signup</a></small>
</p>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>
