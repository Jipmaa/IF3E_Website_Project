<?php
// Start the session to access session variables.
session_start();

// Enable error reporting for debugging purposes.
ini_set('display_errors', 1);  // Display errors to help identify issues.
ini_set('display_startup_errors', 1);  // Display errors during the startup phase.
error_reporting(E_ALL);  // Report all types of errors.


// Check if the session has the 'id_client' key.
// If not, display an error message and stop the script.
if (!isset($_SESSION["id_client"])) {  // If 'id_client' is not set in the session.
    echo "Error: No client ID.";  // Display an error message.
    exit;  // Stop further execution.
}

// Get the client ID from the session.
$id_client = $_SESSION["id_client"];  // Assign the client ID from the session to a variable.

// Establish a connection to the database using PDO.
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");  // Connect to the database.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Set the error mode for the database connection.

// Prepare a SQL query to select the client's earned points and loyalty ID based on the client ID.
$req = $db->prepare("SELECT point_earned, id_loyalty FROM login_client WHERE id_client = :id_client");  // Prepare the query.
$req->execute(array("id_client" => $id_client));  // Execute the query, passing the client ID as a parameter.

// Fetch the results from the database.
$data = $req->fetch(PDO::FETCH_ASSOC);  // Fetch the data as an associative array.

// If no points are earned, set the session variables for points and loyalty ID.
if (!$data["point_earned"]) {  // If the client has not earned any points.
    $_SESSION["point_earned"] = $data["point_earned"];  // Store the points in the session.
    $_SESSION["id_loyalty"] = $data["id_loyalty"];  // Store the loyalty ID in the session.
}

// Check the earned points and set the loyalty level accordingly.
if ($_SESSION["point_earned"] < 1000) {  // If the client has less than 1000 points.
    $_SESSION["id_loyalty"] = 1;  // Set the loyalty level to 1.
}

if ($_SESSION["point_earned"] >= 1000 && $_SESSION["point_earned"] < 2000) {  // If the client has between 1000 and 1999 points.
    $_SESSION["id_loyalty"] = 2;  // Set the loyalty level to 2.
}

if ($_SESSION["point_earned"] >= 2000 && $_SESSION["point_earned"] < 5000) {  // If the client has between 2000 and 4999 points.
    $_SESSION["id_loyalty"] = 3;  // Set the loyalty level to 3.
}

if ($_SESSION["point_earned"] >= 5000) {  // If the client has 5000 or more points.
    $_SESSION["id_loyalty"] = 4;  // Set the loyalty level to 4.
}

// Prepare an SQL query to update the client's loyalty level in the database.
$req = $db->prepare("UPDATE login_client SET id_loyalty = :id_loyalty WHERE id_client = :id_client");  // Prepare the update query.
$req->execute(array("id_loyalty" => $_SESSION["id_loyalty"], "id_client" => $id_client));  // Execute the update query, passing the new loyalty ID and client ID.

// Redirect the user to the loyalty page.
header('Location: ../view/loyalty.php');  // Redirect to the loyalty page to reflect the changes.
exit();  // Ensure no further code is executed after the redirect.
?>
