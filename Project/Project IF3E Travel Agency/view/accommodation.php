<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/accommodation.css">
</head>
<body>

<header>
    <div class="nav-container">
        <div class="logo">
            <img src="../pictures/Sheep%20Travel%20Agency%20Logo.png" alt="Image 0">
            <h1>Sheep's Travel</h1>
        </div>
        <nav>
            <ul>
                <li><a href="menu_client.php">Home</a></li>
                <li><a href="booking.php" class = "protected-link">Booking</a></li>
                <li><a href="loyalty.php" class = "protected-link">Loyalty</a></li>
                <li><a href="client_history_reservation.php" class="protected-link">History</a></li>
                <li><a href="feedback.php" class = "protected-link">Feedback</a></li>
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

<section id="accommodation-section">
    <h2>Manage your accommodation booking</h2>
    <form id="booking-form" action="../controller/accommodation.php" method="POST">
        <label for="accommodation_name">Select Accommodation:</label>
        <select id="id_accommodation" name="id_accommodation">
            <?php
            // Ici, on vérifie si une option a été sélectionnée et on passe la variable $id_accommodation_list à la requête
            try {
                $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $id_accommodation_list = 0;
                //$id_accommodation_list = $_POST['id_accommodation_list'] ?? 0;
                if ($id_accommodation_list > 0) {
                    $stmt = $db->prepare("SELECT id_accommodation, accommodation_name FROM accommodation WHERE id_accommodation_list = :id_accommodation_list");
                    $stmt->bindParam(':id_accommodation_list', $id_accommodation_list, PDO::PARAM_INT);
                } else {
                    $stmt = $db->prepare("SELECT id_accommodation, accommodation_name FROM accommodation");
                }

                $stmt->execute();
                $accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($accommodations) > 0) {
                    foreach ($accommodations as $accommodation) {
                        echo "<option value=\"" . htmlspecialchars($accommodation['id_accommodation']) . "\">" . htmlspecialchars($accommodation['accommodation_name']) . "</option>";
                    }
                } else {
                    echo "<option disabled>No accommodation available</option>";
                }
            } catch (PDOException $e) {
                echo "<option disabled>Error loading accommodations</option>";
            }
            ?>
        </select>

        <label for="checkin_date">Check-in Date:</label>
        <input type="date" id="checkin_date" name="checkin_date" required>

        <label for="checkout_date">Check-out Date:</label>
        <input type="date" id="checkout_date" name="checkout_date" required>

        <label for="special_requests">Special Requests:</label>
        <textarea id="special_requests" name="special_requests" placeholder="Any special requests?"></textarea>


        <button type="submit">Book Now</button>
    </form>


</section>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>
