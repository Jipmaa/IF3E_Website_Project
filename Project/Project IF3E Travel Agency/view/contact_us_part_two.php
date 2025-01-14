<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/contact_us.css">
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

<p5>Votre message a bien été envoyé.</p5>

<!-- Script de vérification de connexion -->
<script>
    document.querySelectorAll('.protected-link').forEach(link => {
        link.addEventListener('click', function (e) {
            <?php if (!isset($_SESSION['email'])): ?>
            e.preventDefault();
            alert("Veuillez vous connecter pour accéder à cette page.");
            window.location.href = '../view/login_client.php';
            <?php endif; ?>
        });
    });
</script>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>