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

<!-- Section Contact -->
<main>
    <section class="contact-us">
        <h2>Contact Us</h2>
        <p>We are here to help! Please feel free to contact us with any questions or booking enquiries.</p>

        <div class="contact-info">
            <h3>Contact Informations</h3>
            <p><strong>Address:</strong> 7 Rue de Leupe, Sevenans, France</p>
            <p><strong>Phone number:</strong> +33 1 23 45 67 89</p>
            <p><strong>Email:</strong> contact@sheepstravel.com</p>
        </div>

        <div class="contact-form">
            <h3>Send us a message</h3>
            <form action="contact_us_part_two.php?success=1" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Matter:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send</button>
            </form>
        </div>

        <!-- Carte de localisation (Google Maps) -->
        <div class="map">
            <h3>Our Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.1769567227634!2d6.863854675884666!3d47.58805638925868!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47923d323c67c747%3A0xbf8a22474db0f7ce!2sUTBM%20-%20Campus%20de%20Sevenans!5e1!3m2!1sfr!2sfr!4v1731342585390!5m2!1sfr!2sfr%22" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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