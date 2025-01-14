<?php
// Start the session to access session variables and handle the user's session.
session_start();

// Check if the 'id_reservation' parameter is passed in the URL.
if (!isset($_GET['id_reservation'])) {  // If 'id_reservation' is not set in the GET request.
    echo "No reservation ID.";  // Display an error message.
    exit;  // Stop further script execution.
}

// Check if the 'amount' parameter is passed in the URL.
if (!isset($_GET['amount'])) {  // If 'amount' is not set in the GET request.
    echo "No amount.";  // Display an error message.
    exit;  // Stop further script execution.
}

// Check if the 'point_earned' session variable is set.
if (!isset($_SESSION['point_earned'])) {  // If 'point_earned' is not set in the session.
    echo "No points earned.";  // Display an error message.
    exit;  // Stop further script execution.
}

// Check if the 'id_client' session variable is set.
if (!isset($_SESSION['id_client'])) {  // If 'id_client' is not set in the session.
    echo "No client ID.";  // Display an error message.
    exit;  // Stop further script execution.
}

// Retrieve the reservation ID, amount, and client information.
$id_reservation = $_GET['id_reservation'];  // Get the reservation ID from the URL.
$amount = $_GET['amount'];  // Get the amount from the URL.
$point_earned = $_SESSION['point_earned'] + (int)$amount * 2;  // Calculate new points earned by adding twice the amount to the current points.
$id_client = $_SESSION['id_client'];  // Get the client ID from the session.

// Establish a connection to the database using PDO.
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");  // Connect to the database.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Set the error mode to exceptions.
} catch (PDOException $e) {  // Catch any database connection errors.
    echo "Connection error: " . $e->getMessage();  // Display the error message.
    exit;  // Stop further script execution.
}

// Prepare and execute a query to update the reservation status to 'confirmed'.
$stmt = $db->prepare("UPDATE reservation_client SET status = 'confirmed' WHERE id_reservation = ?");  // Prepare the SQL query.
$stmt->execute([$id_reservation]);  // Execute the query, passing the reservation ID.

// Prepare and execute a query to update the client's points earned in the database.
$stmt = $db->prepare("UPDATE login_client SET point_earned = $point_earned WHERE id_client = ?");  // Prepare the SQL query.
$stmt->execute([$id_client]);  // Execute the query, passing the client ID.

// Redirect the user to the reservation history page with a success message.
header('Location: ../view/client_history_reservation.php?success=1');  // Redirect to the reservation history page with a success query parameter.
exit;  // Ensure no further code is executed after the redirect.
?>
