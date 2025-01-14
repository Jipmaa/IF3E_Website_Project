<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Staff - Sheep's Travel</title>
    <link rel="stylesheet" href="../styles/create_client.css">
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
<h1>Create new staff member</h1>

<form action="../controller/staff_create_staff.php" method="POST">
    <label for="first_name">First name:</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="phone_number">Phone number:</label>
    <input type="tel" name="phone_number" id="phone_number" required>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
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

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="birthdate">Birthdate:</label>
    <input type="date" name="birthdate" id="birthdate" required>

    <button type="submit">Create Staff</button>
</form>
</body>
</html>
