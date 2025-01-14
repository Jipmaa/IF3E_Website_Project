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

    <?php
    try {
        // Connexion à la base de données
        $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérification de la session
        if (!isset($_SESSION["id_client"])) {
            echo "<h2>ID client non disponible. Veuillez vous connecter.</h2>";
            exit;
        }

        $id_client = $_SESSION["id_client"];

        // Requête pour récupérer les points et l'ID de fidélité
        $req = $db->prepare("SELECT id_loyalty, point_earned FROM login_client WHERE id_client = :id_client");
        $req->execute([':id_client' => $id_client]);
        $data = $req->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $_SESSION["id_loyalty"] = $data["id_loyalty"];
            $_SESSION["point_earned"] = $data["point_earned"];
            $id_loyalty = $data["id_loyalty"];
            $point_earned = $data["point_earned"];

            // Requête pour récupérer le statut de fidélité
            $req = $db->prepare("SELECT loyalty_status FROM loyalty_program WHERE id_loyalty = :id_loyalty");
            $req->execute([':id_loyalty' => $id_loyalty]);
            $loyalty_data = $req->fetch(PDO::FETCH_ASSOC);

            // Affichage des informations
            if ($loyalty_data) {
                echo "<h2>Your loyalty rank: " . htmlspecialchars($loyalty_data["loyalty_status"]) . "</h2>";
                echo "<h2>You have " . htmlspecialchars($point_earned) . " points.</h2>";
            } else {
                echo "<h2>No loyalty status found.</h2>";
            }
        } else {
            echo "<h2>Loyalty ID not found. Please log in.</h2>";
        }
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur : " . $e->getMessage();
    }
    ?>

    <section class="info-section">
        <img src="../pictures/bronze.png" alt="Image 1">
        <div class="info-text">
            <h2>Bronze</h2>
            <p>The bronze loyalty is the beginning of the loyalty.</p>
            <p>- 10% reduction for your next transport / accommodation</p>
            <p>- A small birthday gift (physical or digital)</p>
            <p>- Access to our Bronze Member Newsletter with travel tips, destination guides, and upcoming promotions</p>
        </div>
    </section>

    <section class="info-section">
        <img src="../pictures/silver.png" alt="Image 2">
        <div class="info-text">
            <h2>Silver</h2>
            <p>The Silver loyalty level unlocks a higher world of perks and privileges, reserved for members with 1000 points and above.</p>
            <p>- 15% reduction for your next transport / accommodation</p>
            <p>- Birthday surprise gift (physical or digital)</p>
            <p>- Early access to special deals and discounts</p>
            <p>- Free upgrade to premium seating (when available)</p>
        </div>
    </section>

    <section class="info-section">
        <img src="../pictures/gold.png" alt="Image 3">
        <div class="info-text">
            <h2>Gold</h2>
            <p>The Gold loyalty level represents a major milestone, offering exclusive rewards for members with 2000 points and above.</p>
            <p>- 20% reduction for your next transport / accommodation</p>
            <p>- Birthday surprise gift (physical or digital)</p>
            <p>- Priority booking for exclusive events and offers</p>
            <p>- Complimentary lounge access at partner locations</p>
            <p>- Personal concierge service for travel planning</p>
            <p>- Double points on every purchase for a month after reaching Gold</p>
        </div>
    </section>

    <section class="info-section">
        <img src="../pictures/diamond.png" alt="Image 4">
        <div class="info-text">
            <h2>Diamond</h2>
            <p>The Diamond loyalty level is the pinnacle of our program, reserved for our most dedicated members with 5000 points and above.</p>
            <p>- 25% reduction for your next transport / accommodation</p>
            <p>- Birthday surprise gift (physical or digital)</p>
            <p>- Access to exclusive Diamond-only events and trips</p>
            <p>- Personalized gifts and services tailored to your preferences</p>
            <p>- Priority support with a dedicated agent</p>
            <p>- Complimentary travel insurance on all bookings</p>
        </div>
    </section>

</main>

<nav>
    <ul>
        <li><a href="menu_client.php">Home</a></li>
        <li><a href="booking.php" class="protected-link">Booking</a></li>
        <li><a href="loyalty.php" class="protected-link">Loyalty</a></li>
        <li><a href="feedback.php" class="protected-link">Feedback</a></li>
        <li><a href="contact_us.php">Contact</a></li>
    </ul>
</nav>

<footer class="footer">
    <p>© 2024 Sheep's Travel Agency. All rights reserved.</p>
</footer>

</body>
</html>
