<?php
// Start a session to handle session variables
session_start();

// Reset session to avoid conflicts
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
session_start(); // Start a new session

// Enable error messages for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize email and password variables
$email = "";
$password = "";

// 1. Check if session variables are set
if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    // If session variables exist, retrieve email and password
    $email = strtolower(trim($_SESSION["email"])); // Normalize email to lowercase and trim whitespace
    $password = $_SESSION["password"]; // Get password from session
}
// 2. Otherwise, use POST data if available
elseif (isset($_POST["email"]) && isset($_POST["password"])) {
    // Retrieve email and password from POST data
    $email = strtolower(trim($_POST["email"])); // Normalize and clean email
    $password = $_POST["password"]; // Get password from POST data
} else {
    // If neither session nor POST data is available, redirect to login page
    header("Location: ../view/login_client.php");
    exit();
}

try {
    // Database connection (using PDO)
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error handling mode

    // Prepare SQL query to check if the email exists in the database
    $req = $db->prepare("SELECT email, password, first_name, id_client, point_earned, id_loyalty FROM login_client WHERE email = ?");
    $req->execute([$email]); // Execute the query with the provided email

    // Fetch the result from the database
    $data = $req->fetch(PDO::FETCH_ASSOC);

    // Debugging: output the result and email (can be removed later)
    var_dump($data);
    var_dump($email);

    // Check if the password matches the hashed password in the database
    if ($data && password_verify($password, $data['password'])) {
        // Store necessary data in session variables
        $_SESSION["email"] = $email; // Store email in session
        $_SESSION["first_name"] = $data["first_name"]; // Store first name in session
        $_SESSION["id_client"] = $data["id_client"]; // Store client ID in session
        $_SESSION["point_earned"] = $data["point_earned"]; // Store earned points in session
        $_SESSION["id_loyalty"] = $data["id_loyalty"]; // Store loyalty ID in session

        // Redirect to the client menu page after successful login
        header("Location: ../view/menu_client.php");
        exit();
    } else {
        // If email or password is incorrect, display error and redirect to login page with error message
        echo "Incorrect email or password.";
        header("Location: ../view/login_client.php?error=email/password");
    }
} catch (Exception $e) {
    // Catch any exceptions (database errors) and display the error message
    echo "Error: " . $e->getMessage();
    exit();
}
?>
