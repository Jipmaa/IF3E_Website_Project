<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit();
}

$id_client = $_SESSION['id_client'];
$id_reservation = isset($_GET['id_reservation']) ? $_GET['id_reservation'] : null;

if (!$id_reservation) {
    die('Invalid reservation ID.');
}

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Récupérer les détails de la réservation
$query = $db->prepare("SELECT * FROM reservation_client WHERE id_reservation = :id_reservation AND id_client = :id_client");
$query->execute([':id_reservation' => $id_reservation, ':id_client' => $id_client]);
$reservation = $query->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die('Reservation not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment for Reservation</title>
    <link rel="stylesheet" href="../styles/client_history_reservation.css">
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <section class="payment">
        <h2>Payment for Reservation #<?php echo htmlspecialchars($reservation['id_reservation']); ?></h2>
        <p><strong>Check-in:</strong> <?php echo htmlspecialchars($reservation['checkin_date']); ?></p>
        <p><strong>Check-out:</strong> <?php echo htmlspecialchars($reservation['checkout_date']); ?></p>
        <p><strong>Amount Due:</strong> <?php echo htmlspecialchars(number_format($reservation['price'], 2)); ?> $</p>

        <!-- Formulaire de paiement -->
        <form action="../controller/payement.php" method="GET">
            <!-- Passer id_reservation dans l'URL avec la méthode GET -->
            <input type="hidden" name="id_reservation" value="<?php echo htmlspecialchars($reservation['id_reservation']); ?>">
            <input type="hidden" name="amount" value="<?php echo htmlspecialchars($reservation['price']); ?>">

            <div class="form-group">
                <label for="card_name">Name on Card</label>
                <input type="text" id="card_name" name="card_name" required>
            </div>
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="month" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="btn">Pay Now</button>
        </form>
    </section>
</main>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>
