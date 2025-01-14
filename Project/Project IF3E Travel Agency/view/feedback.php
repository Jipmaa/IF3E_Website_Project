<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/feedback.css">
</head>
<body>

<!-- Menu de navigation -->
<header>
    <div class="nav-container">
        <div class="logo">
            <img src="../pictures/Sheep%20Travel%20Agency%20Logo.png" alt="Logo Sheep's Travel">
            <h1>Sheep's Travel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="menu_client.php">Home</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="loyalty.php">Loyalty</a></li>
                <li><a href="client_history_reservation.php" class="protected-link">History</a></li>
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="contact_us.php">Contact</a></li>
            </ul>
        </nav>
        <div class="login-signup">
            <?php
            session_start();
            if (!isset($_SESSION["first_name"])): ?>
                <a href="../view/login_client.php">Login</a> | <a href="../view/signup.php">Signup</a>
            <?php else: ?>
                <span>Welcome, <?php echo $_SESSION["first_name"]; ?></span>
                <a href="../controller/signout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Section Feedback -->
<main>
    <section class="feedback">
        <h2>We are interested in your opinion</h2>
        <p>Thank you for sharing your experience with Sheep's Travel. Your feedback helps us to improve our services.</p>

        <div class="feedback-form">
            <form action="../controller/feedback.php" method="POST">
                <label for="rating">Service used:</label>
                <select id="id_service" name="id_service" required>
                    <option value="" disabled selected>-- Please choose a service --</option>
                    <option value="1">Accommodation</option>
                    <option value="2">Transport</option>
                    <option value="3">Package</option>
                </select>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="rating">Satisfaction Rating:</label>
                <select id="rating" name="rating" required>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Satisfying</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Bad</option>
                </select>

                <label for="message">Your Feedback:</label>
                <textarea id="comments" name="comments" rows="5" required></textarea>

                <button type="submit">Send</button>
            </form>
        </div>
    </section>
</main>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>