<?php
session_start();

// Check if the client is logged in
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['id_client'];

// Database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Fetch reservations for the logged-in client
$query = $db->prepare("SELECT * FROM reservation_client WHERE id_client = :id_client ORDER BY id_reservation DESC");
$query->execute([':id_client' => $id_client]);
$reservations = $query->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <link rel="stylesheet" href="../styles/client_history_reservation.css">
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

<main>
    <section class="reservations">
        <h2>My Reservations</h2>
        <?php if (empty($reservations)) : ?>
            <p>You have no reservations yet. <a href="booking.php">Make a reservation now!</a></p>
        <?php else : ?>
            <table>
                <thead>
                <tr>
                    <th>ID Reservation</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['id_reservation']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['checkin_date']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['checkout_date'] ); ?></td>
                        <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($reservation['price'], 2)); ?> $</td>
                        <td>
                            <?php if ($reservation['status'] == 'pending') : ?>
                                <a href="payement.php?id_reservation=<?php echo $reservation['id_reservation']; ?>" class="btn">Pay Now</a>
                                <a href="../controller/canceled.php?id_reservation=<?php echo $reservation['id_reservation']; ?>&status='confirmed'&price=<?php echo number_format($reservation['price']); ?>" class="btn">Canceled</a>
                            <?php elseif ($reservation['status'] == 'confirmed') : ?>
                                <a href="../controller/canceled.php?id_reservation=<?php echo $reservation['id_reservation']; ?>&status='confirmed'&price=<?php echo number_format($reservation['price']); ?>" class="btn">Canceled</a>
                            <?php else : ?>
                                <p>No action possible</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</main>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>