<?php
// Enable PHP error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify that all required fields are provided
    if (!isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["first_name"]) || !isset($_POST["birthdate"]) || !isset($_POST["id_client"]) || !isset($_POST["point_earned"])) {
        echo "Email, password, name, first name, birthdate, or points are missing!";
        exit();
    }

    // Retrieve and sanitize input data
    $email = strtolower(trim($_POST["email"])); // Lowercase and trim email
    $name = ucwords(strtolower($_POST["name"])); // Capitalize name
    $first_name = ucwords(strtolower(trim($_POST["first_name"]))); // Capitalize and trim first name
    $birthdate = $_POST["birthdate"]; // Retrieve birthdate
    $id_client = $_POST["id_client"]; // Retrieve client ID
    $point_earned = $_POST["point_earned"]; // Retrieve earned points

    // Check if a password has been provided (indicates a change of password)
    if (!empty($_POST["password"])) {
        // Hash the new password using BCRYPT
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    } else {
        // If no new password is provided, retain the existing password
        // Connect to the database
        $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        // Prepare SQL query to fetch the current password for the client
        $stmt = $db->prepare("SELECT password FROM login_client WHERE id_client = :id_client");
        $stmt->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            $password = $client['password']; // Keep the existing password
        } else {
            // If the client does not exist, show an error message
            echo "Error: Client not found.";
            exit();
        }
    }

    // Establish a connection to the database
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

    // Prepare the SQL query to update the client's information
    $req = $db->prepare("UPDATE login_client 
                         SET email = :email, 
                             name = :name, 
                             first_name = :first_name, 
                             password = :password, 
                             birthdate = :birthdate, 
                             point_earned = :point_earned 
                         WHERE id_client = :id_client");

    // Execute the query with the provided data
    $req->execute([
        ':email' => $email,
        ':name' => $name,
        ':first_name' => $first_name,
        ':password' => $password,
        ':birthdate' => $birthdate,
        ':id_client' => $id_client,
        ':point_earned' => $point_earned
    ]);

    // Redirect to the client management page after updating the information
    header("Location: ../view/staff_clients_management.php");
    exit();
} else {
    // If the request method is not POST, redirect to the login page
    header("Location: ../view/login_staff.php");
    exit();
}
?>
