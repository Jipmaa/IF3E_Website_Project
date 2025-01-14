<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/booking.css">
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
                <span>Welcome, <?php echo $_SESSION["first_name"]; ?></span>
                <a href="../controller/signout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Section des options de réservation -->
<div class="booking-section">
    <a href="accommodation.php">
    <div class="booking-container">
        <div class="booking-option">

            <img src="../pictures/accommodation.jpg" alt="Accommodation">

            <div class="overlay">
                <h2>Accommodation</h2>
            </div>
        </div>
    </a>
    <a href="transport.php">
        <div class="booking-option">
            <img src="../pictures/transportation.png" alt="Transport">
            <div class="overlay">
                <h2>Transportation</h2>
            </div>
        </div>
    </a>
    <a href="package.php">
        <div class="booking-option">
            <img src="../pictures/package.png" alt="Package">
            <div class="overlay">
                <h2>Package</h2>
            </div>
        </div>
    </a>
    </div>
</div>

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
