<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Management</title>
    <link rel="stylesheet" href="../styles/clients_management.css">
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

<div class="title-button-container">
    <h1>Clients Management</h1>
    <a href="staff_staff_management.php" class="toggle-button">Staff</a>
</div>
<!-- Formulaire de recherche -->
<form method="GET" action="" class="search-form">
    <input type="val" name="id_client" placeholder="ID" />
    <input type="text" name="name" placeholder="Nom" />
    <input type="text" name="first_name" placeholder="First Name" />
    <input type="text" name="email" placeholder="Email" />
    <input type="date" name="birthdate" placeholder="Birthdate" />
    <button type="submit" class="search-btn">Rechercher</button>
    <a href="staff_clients_management.php" class="reset-btn">Rénitialiser</a>
</form>

<a href="staff_create_client.php" class="btn">Create a new client</a>
<a href="staff_create_staff.php" class="btn">Create a new employee</a>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>First Name</th>
        <th>Email</th>
        <th>Birthdate</th>
        <th>Points</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Connexion à la base de données
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

    // Préparation de la requête avec des critères de recherche
    $sql = "SELECT * FROM login_client WHERE 1=1";
    $params = [];

    // Vérification et ajout des critères de recherche
    if (!empty($_GET['id_client'])) {
        $sql .= " AND id_client LIKE ?";
        $params[] = '%' . $_GET['id_client'] . '%';
    }
    if (!empty($_GET['first_name'])) {
        $sql .= " AND first_name LIKE ?";
        $params[] = '%' . $_GET['first_name'] . '%';
    }
    if (!empty($_GET['name'])) {
        $sql .= " AND name LIKE ?";
        $params[] = '%' . $_GET['name'] . '%';
    }
    if (!empty($_GET['email'])) {
        $sql .= " AND email LIKE ?";
        $params[] = '%' . $_GET['email'] . '%';
    }
    if (!empty($_GET['birthdate'])) {
        $sql .= " AND birthdate LIKE ?";
        $params[] = '%' . $_GET['birthdate'] . '%';
    }
    if (!empty($_GET['point_earned'])) {
        $sql .= " AND point_earned LIKE ?";
        $params[] = '%' . $_GET['point_earned'] . '%';
    }

    // Préparation et exécution de la requête
    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    // Affichage des résultats
    while ($client = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($client['id_client']) . "</td>
                <td>" . htmlspecialchars($client['name']) . "</td>
                <td>" . htmlspecialchars($client['first_name']) . "</td>
                <td>" . htmlspecialchars($client['email']) . "</td>
                <td>" . htmlspecialchars($client['birthdate']) . "</td>
                <td>" . htmlspecialchars($client['point_earned']) . "</td>
                <td>
                    <a href='staff_edit_client.php?id_client=" . $client['id_client'] . "'>Modifier</a> |
                    <a href='../controller/delete_client.php?id_client=" . $client['id_client'] . "'>Supprimer</a>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>
