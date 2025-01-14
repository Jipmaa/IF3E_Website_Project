<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/edit_client.css">
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
                <li><a href="staff_clients_management.php">Home</a></li>
                <li><a href="staff_create_client.php" class="protected-link">Create Client</a></li>
                <li><a href="staff_create_staff.php" class="protected-link">Create Staff</a></li>
            </ul>
        </nav>
        <?php
        session_start();
        ?>

        <div class="login-signup">
            <!-- Si l'utilisateur est connecté, afficher un message de bienvenue et un bouton de déconnexion -->
            <span>Welcome, <?php echo $_SESSION["first_name"]; ?></span>
            <a href="../controller/signout.php">Logout</a>
        </div>
        <!-- Script de vérification de connexion -->
        <script>
            document.querySelectorAll('.protected-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    <?php if (!isset($_SESSION['email'])): ?>
                    e.preventDefault();
                    alert("Veuillez vous connecter pour accéder à cette page.");
                    window.location.href = '../view/login_staff.php';
                    <?php endif; ?>
                });
            });
        </script>
    </div>
</header>
<h1>Modify client profile</h1>

<?php
// Connexion à la base de données
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

// Vérification si 'id_client' est passé dans l'URL
if (isset($_GET['id_client'])) {
    $id = $_GET['id_client'];

    // Préparer la requête pour récupérer les informations du client
    $stmt = $db->prepare("SELECT * FROM login_client WHERE id_client = :id ");
    $stmt->bindParam("id", $id, PDO::PARAM_INT);  // Assurez-vous d'utiliser PDO::PARAM_INT
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si aucun client n'est trouvé avec cet ID, afficher un message d'erreur
    if (!$client) {
        echo "<p>Client not found</p>";
        exit();
    }
} else {
    // Si l'ID du client n'est pas dans l'URL, afficher une erreur
    echo "<p>ID client missing</p>";
    exit();
}
?>

<form action="../controller/edit_client.php" method="POST">
    <input type="hidden" name="id_client" value="<?php echo $client['id_client']; ?>">

    <label for="first_name">First name :</label>
    <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($client['first_name']); ?>" required>

    <label for="name">Name :</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($client['name']); ?>" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>

    <label for="point_earned">Points :</label>
    <input type="text" name="point_earned" id="point_earned" value="<?php echo htmlspecialchars($client['point_earned']); ?>" required>

    <label for="birthdate">Birthdate :</label>
    <input type="date" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($client['birthdate']); ?>" required>

    <label for="password">Password :</label>
    <input type="password" name="password" id="password" placeholder="Empty if no change">

    <button type="submit">Update</button>
</form>

</body>
</html>
