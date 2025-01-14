<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Sheep's Travel</title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="../styles/signup.css">
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
                <li><a href="menu_client.php">Home</a></li>
                <li><a href="booking.php" class="protected-link">Booking</a></li>
                <li><a href="loyalty.php" class="protected-link">Loyalty</a></li>
                <li><a href="client_history_reservation.php" class="protected-link">History</a></li>
                <li><a href="feedback.php" class="protected-link">Feedback</a></li>
                <li><a href="contact_us.php">Contact</a></li>
            </ul>
        </nav>
        <?php
        session_start();
        ?>

        <div class="login-signup">
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

<div class="head">
    <h1>Signup</h1>
</div>

<form method="post" action="../controller/signup.php">
    <label>
        Email :
        <input type="text" name="email" spellcheck="false" placeholder="abc.def@utbm.fr" title="Please enter your email" required="required"/>
    </label>
    <label>
        Nom :
        <input type="text" name="name" />
    </label>
    <label>
        Prénom :
        <input type="text" name="first_name" />
    </label>
    <label>
        Mot de passe :
        <input type="password" name="password" />
    </label>
    <label>
        Date de naissance :
        <input type="date" name="birthdate" />
    </label>
    <input type="submit" value="S'inscrire"/>
</form>

<!-- Lien vers la page d'inscription -->
<p class="signup-link" style="text-align: center;">
    <small>Déjà un compte ? <a href="login_client.php">Login</a></small>
</p>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>
