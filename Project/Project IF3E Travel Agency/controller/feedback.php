<?php
// Start the session to use session variables
session_start();

// Enable error messages for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if required information is provided via POST and session
if (!isset($_SESSION["id_client"]) || !isset($_POST["id_service"]) || !isset($_POST["email"]) || !isset($_POST["comments"]) || !isset($_POST["rating"])) {
    exit("Missing information.");
}

// Retrieve and sanitize POST data
$id_service = $_POST["id_service"];  // Service ID
$email = $_POST["email"];  // Client's email
$comments = $_POST["comments"];  // Client's feedback comments
$rating = $_POST["rating"];  // Rating score
$feedback_date = date("Y-m-d");  // Current date for the feedback
$id_client = $_SESSION["id_client"];

// Database connection
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Prepare the query to insert feedback into the database
$req = $db->prepare("INSERT INTO feedback (id_client, id_service, comments, rating, feedback_date) VALUES (?, ?, ?, ?, ?)");

// Execute the query with the provided data
if ($req->execute([$id_client, $id_service, $comments, $rating, $feedback_date])) {
    // On success, redirect to the client menu with a success message
    header("Location: ../view/menu_client.php?success=1");
    exit();
} else {
    echo "Error inserting feedback into the database.";
    exit();
}
?>
