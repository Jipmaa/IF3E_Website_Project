<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/menu_client.css">
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
                <li><a href="../controller/loyalty.php" class="protected-link">Loyalty</a></li>
                <li><a href="client_history_reservation.php" class="protected-link">History</a></li>
                <li><a href="feedback.php" class="protected-link">Feedback</a></li>
                <li><a href="contact_us.php">Contact</a></li>
            </ul>
        </nav>
        <?php
        session_start();
        ?>

        <div class="login-signup">
            <?php if (!isset($_SESSION["first_name"]) || !isset($_SESSION["id_client"])): ?>
                <a href="../view/login_client.php">Login</a> | <a href="../view/signup.php">Signup</a>
            <?php else: ?>
                <!-- Si l'utilisateur est connecté, afficher un message de bienvenue et un bouton de déconnexion -->
                <span>Welcome, <?php echo $_SESSION["first_name"]; ?></span>
                <a href="../controller/signout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Sections d'informations -->
<main>
    <section class="info-section">
        <a href = "booking.php"><img src="../pictures/Service.jpg" alt="Image 1"></a>
        <div class="info-text">
            <h2><a href = "booking.php">Our Services</a></h2>
            <p><a href = "booking.php">Discover our wide range of services. Tailored to your needs for a unique and personal experience.</a></p>
        </div>
    </section>

    <section class="info-section">
        <a href = "package.php" class="protected-link"><img src="../pictures/Offer.png" alt="Image 2"></a>
        <div class="info-text">
            <h2><a href = "package.php" class="protected-link">Our Special Offers</a></h2>
            <p><a href = "package.php" class="protected-link">Take advantage of our special offers and exclusive promotions available throughout the year.</a></p>
        </div>
    </section>

    <section class="info-section">
        <a href = "about_us.php" class="protected-link"><img src="../pictures/About_us.jpg" alt="Image 3"></a>
        <div class="info-text">
            <h2><a href = "about_us.php" class="protected-link">About Us</a></h2>
            <p><a href = "about_us.php" class="protected-link">Learn more about our history and values that make our company a trusted choice.</a></p>
        </div>
    </section>

    <section class="info-section">
        <a href = "contact_us.php" class="protected-link"><img src="../pictures/Contact_Us.png" alt="Image 4"></a>
        <div class="info-text">
            <h2><a href = "contact_us.php" class="protected-link">Contact Us</a></h2>
            <p><a href = "contact_us.php" class="protected-link">Need some help? Our team is here to answer any questions you may have.</a></p>
        </div>
    </section>
</main>

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
