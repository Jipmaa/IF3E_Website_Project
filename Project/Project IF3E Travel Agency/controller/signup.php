<?php
// Enable error messages for easier debugging
ini_set('display_errors', 1);  // Enable display of all errors
ini_set('display_startup_errors', 1);  // Enable errors during startup
error_reporting(E_ALL);  // Report all types of errors

// Check if the required form data is provided
if (!isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["first_name"]) || !isset($_POST["password"]) || !isset($_POST["birthdate"])) {
    return;  // If any required data is missing, exit the script
}

// Simplify the use of variables by sanitizing and formatting the input
$email = strtolower(trim($_POST["email"]));  // Sanitize email by trimming and converting to lowercase
$name = ucwords(strtolower($_POST["name"]));  // Format the name to have the first letter capitalized
$first_name = ucwords(strtolower(trim($_POST["first_name"])));  // Format first name similarly
$password = $_POST["password"];  // Store password as is (it will be hashed later)
$birthdate = $_POST["birthdate"];  // Get the birthdate directly from the form

// Connect to the database
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");  // Establish a PDO connection to the database
} catch (Exception $e) {
    die('Error : ' . $e->getMessage());  // Handle connection errors
}

// Check if the email already exists in the database
$checkEmail = $db->prepare("SELECT COUNT(*) FROM login_client WHERE email = ?");
$checkEmail->execute([strtolower(trim($_POST["email"]))]);  // Execute the query with the sanitized email
$emailExists = $checkEmail->fetchColumn();  // Fetch the result as a count of rows with the given email

if ($emailExists > 0) {
    // If the email is already in use, display an error message and stop execution
    echo "This email is already used. Please choose another one.";
    exit();
}

// Default points for a new user
$point_earned = 100;

// Prepare the SQL query to insert the new client into the database
$req = $db->prepare("INSERT INTO login_client (email, name, first_name, password, birthdate, point_earned) VALUES (?, ?, ?, ?, ?, ?)");

// Execute the query, hashing the password before storing it in the database
if ($req->execute([$email, $name, $first_name, password_hash($password, PASSWORD_DEFAULT), $birthdate, $point_earned])) {
    // If the insertion is successful, start a session and store client data
    session_start();
    $_SESSION["email"] = $email;  // Store email in session
    $_SESSION["password"] = $password;  // Store raw password in session (usually not recommended to store raw password)
    $_SESSION["name"] = $name;  // Store name in session
    $_SESSION["birthdate"] = $birthdate;  // Store birthdate in session
    $_SESSION["first_name"] = $first_name;  // Store first name in session
    $_SESSION["point_earned"] = 100;  // Set the default points earned in session
    $_SESSION["id_loyalty"] = 1;  // Set the initial loyalty ID for the new client (basic loyalty tier)
    header("Location: login_client.php");  // Redirect the user to the login page
} else {
    // If insertion fails, print the error information from the database query
    print_r($req->errorInfo());  // Debugging output of any error from the database
}
?>
