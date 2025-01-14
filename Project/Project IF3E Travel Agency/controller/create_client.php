<?php
// Enable PHP error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify that all required fields are provided
    if (!isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["first_name"]) || !isset($_POST["birthdate"]) || !isset($_POST["password"])) {
        echo "Missing required information";
        exit();
    }

    // Retrieve and sanitize user input
    $email = strtolower(trim($_POST["email"])); // Convert email to lowercase and remove whitespace
    $name = ucwords(strtolower($_POST["name"])); // Capitalize the first letter of each word in the name
    $first_name = ucwords(strtolower(trim($_POST["first_name"]))); // Capitalize and trim the first name
    $birthdate = $_POST["birthdate"]; // Get the birthdate as provided
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password using BCRYPT

    // Connect to the database using PDO
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

    // Prepare an SQL query to insert the client information into the login_client table
    $req = $db->prepare("INSERT INTO login_client (email, name, first_name, password, birthdate) VALUES (?, ?, ?, ?, ?)");

    // Execute the prepared statement and check for errors
    if ($req->execute([$email, $name, $first_name, password_hash($password, PASSWORD_DEFAULT), $birthdate])) {
        // If the insertion is successful, redirect to the client login page
        header("Location: ../view/login_client.php");
    } else {
        // If insertion fails, display the error information
        print_r($req->errorInfo());
    }

    // Redirect the user to the staff client management page after insertion
    header("Location: ../view/staff_clients_management.php");
    exit();
} else {
    // If the request method is not POST, redirect to the staff login page
    header("Location: ../view/login_staff.php");
    exit();
}
?>
