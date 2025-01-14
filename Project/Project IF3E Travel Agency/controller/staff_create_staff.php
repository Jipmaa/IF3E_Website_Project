<?php
// Enable error messages for easier debugging
ini_set('display_errors', 1);  // Enable the display of errors
ini_set('display_startup_errors', 1);  // Enable the display of errors that occur during the startup phase
error_reporting(E_ALL);  // Report all types of errors

// Check if all necessary form data is provided
if (!isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["first_name"]) || !isset($_POST["password"]) || !isset($_POST["birthdate"])) {
    exit;  // If any of the required data is missing, terminate the script
}

// Simplify the usage of variables by sanitizing and formatting input data
$email = strtolower(trim($_POST["email"]));  // Sanitize email (trim spaces and convert to lowercase)
$name = ucwords(strtolower($_POST["name"]));  // Format the name by capitalizing the first letter of each word
$first_name = ucwords(strtolower(trim($_POST["first_name"])));  // Format the first name similarly
$password = $_POST["password"];  // Store password directly (to be hashed later)
$birthdate = $_POST["birthdate"];  // Store birthdate
$phone_number = trim($_POST["phone_number"]);  // Store phone number (trim any leading or trailing spaces)
$role = $_POST["role"];  // Store the role (e.g., admin, staff)

// Connect to the database
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");  // Create a PDO instance and connect to the database
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());  // If connection fails, display the error message and stop execution
}

// Check if the email already exists in the database
$checkEmail = $db->prepare("SELECT COUNT(*) FROM login_staff WHERE email = ?");
$checkEmail->execute([strtolower(trim($_POST["email"]))]);  // Execute the query with the sanitized email
$emailExists = $checkEmail->fetchColumn();  // Fetch the count of rows matching the given email

if ($emailExists > 0) {
    // If the email already exists, show an error message and redirect
    echo "This email is already in use. Please choose another one.";
    header("location: staff_create_staff.php?erreur:email_already_exists");  // Redirect to the staff creation page with an error message
    exit;  // Terminate the script to prevent further execution
}

// Set the default points earned for the new staff member
$point_earned = 100;

// Prepare the SQL query to insert the new staff member into the database
$req = $db->prepare("INSERT INTO login_staff (email, name, first_name, password, birthdate, phone_number, role) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Execute the query with parameterized inputs, and hash the password for secure storage
if ($req->execute([$email, $name, $first_name, password_hash($password, PASSWORD_DEFAULT), $birthdate, $phone_number, $role])) {
    // If the insertion is successful, redirect to the staff management page
    header("location: ../view/staff_staff_management.php");
} else {
    // If the insertion fails, print the error information for debugging
    print_r($req->errorInfo());
}
?>
