<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
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
    <h1>Staff Management</h1>
    <a href="staff_clients_management.php" class="toggle-button">Clients</a>
</div>

<!-- Formulaire de recherche -->
<form method="GET" action="" class="search-form">
    <input type="val" name="id_employee" placeholder="ID" />
    <input type="text" name="name" placeholder="Nom" />
    <input type="text" name="first_name" placeholder="First Name" />
    <input type="text" name="email" placeholder="Email" />
    <input type="date" name="birthdate" placeholder="Birthdate" />
    <select id="role" name="role">
        <option value="null">All</option>
        <option value="Booking Agent">Booking Agent</option>
        <option value="Travel Advisor">Travel Advisor</option>
        <option value="Agency Director">Agency Director</option>
        <option value="Sales Manager">Sales Manager</option>
        <option value="Marketing Manager">Marketing Manager</option>
        <option value="Customer Service Agent">Customer Service Agent</option>
        <option value="Accountant">Accountant</option>
        <option value="Partnership Manager">Partnership Manager</option>
        <option value="Ticketing Agent">Ticketing Agent</option>
        <option value="Event Management Manager">Event Management Manager</option>
        <option value="Administrative Assistant">Administrative Assistant</option>
        <option value="Admin">Admin</option>
    </select>
    <button type="submit" class="search-btn">Rechercher</button>
    <a href="staff_staff_management.php" class="reset-btn">Rénitialiser</a>
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
        <th>Phone number</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Connexion à la base de données
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

    // Préparation de la requête avec des critères de recherche
    $sql = "SELECT * FROM login_staff WHERE 1=1";
    $params = [];

    // Vérification et ajout des critères de recherche
    if (!empty($_GET['id_employee'])) {
        $sql .= " AND id_employee LIKE ?";
        $params[] = '%' . $_GET['id_employee'] . '%';
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
    if (!empty($_GET['phone_number'])) {
        $sql .= " AND phone_number LIKE ?";
        $params[] = '%' . $_GET['phone_number'] . '%';
    }
    if (!empty($_GET['phone_number'])) {
        $sql .= " AND phone_number LIKE ?";
        $params[] = '%' . $_GET['phone_number'] . '%';
    }
    if (!empty($_GET['role']) && $_GET['role'] != 'null') {
        $sql .= " AND role LIKE ?";
        $params[] = '%' . $_GET['role'] . '%';
    }

    // Préparation et exécution de la requête
    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    // Affichage des résultats
    while ($staff = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($staff['id_employee']) . "</td>
                <td>" . htmlspecialchars($staff['name']) . "</td>
                <td>" . htmlspecialchars($staff['first_name']) . "</td>
                <td>" . htmlspecialchars($staff['email']) . "</td>
                <td>" . htmlspecialchars($staff['birthdate']) . "</td>
                <td>" . htmlspecialchars($staff['phone_number']) . "</td>
                <td>" . htmlspecialchars($staff['role']) . "</td>
                <td>
                    <a href='staff_edit_staff.php?id_employee=" . $staff['id_employee'] . "'>Modify</a> |
                    <a href='../controller/delete_staff.php?id_employee=" . $staff['id_employee'] . "'>Delete</a>
                </td>
              </tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>
