<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/about_us.css">
</head>
<body>
<header class="header">
    <div class="nav-container">
        <div class="logo">
            <img src="../pictures/Sheep%20Travel%20Agency%20Logo.png" alt="Logo">
            <h1>Sheep's Travel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="menu_client.php">Home</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="loyalty.php">Loyalty</a></li>
                <li><a href="feedback.php">Feedback</a></li>
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


<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h2>Discover the World with Sheep's Travel</h2>
        <p>Crafting unforgettable adventures for every traveler.</p>
        <a href="booking.php" class="btn">Start Your Journey</a>
    </div>
</section>

<!-- About Section -->
<main>
    <section class="about-section">
        <div class="about-image">
        </div>
        <div class="about-text">
            <h2>About Us</h2>
            <p>Welcome to Sheep's Travel! Founded on a passion for adventure, our agency is dedicated to creating unforgettable travel experiences. Whether you're exploring tranquil landscapes or bustling cities, we offer tailor-made packages to suit every type of traveller.</p>
            <p>Our mission is simple: to connect you with the world. With our expert team, exclusive offers, and a commitment to exceptional service, we take the stress out of planning so you can focus on enjoying your journey.</p>
            <div class="features">
                <div class="feature-item">
                    <img src="../pictures/agent-voyage.jpeg" alt="Expert Consultants">
                    <h3>Expert Consultants</h3>
                    <p>Our travel consultants have in-depth knowledge of global destinations.</p>
                </div>
                <div class="feature-item">
                    <img src="../pictures/printable-travel-itineraries.jpeg" alt="Tailored Packages">
                    <h3>Tailored Packages</h3>
                    <p>Customizable itineraries designed to meet your unique travel needs.</p>
                </div>
                <div class="feature-item">
                    <img src="../pictures/24-7.jpeg" alt="24/7 Support">
                    <h3>24/7 Support</h3>
                    <p>We're here to assist you at every step of your journey.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>
</body>
</html>