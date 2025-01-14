<?php
session_start();

// Check if the required GET and session variables are set
if(!isset($_GET['id_reservation'])){
    echo "No id_reservation provided";
    exit;
}
if(!isset($_GET['price'])){
    echo "No price provided";
    exit;
}
if(!isset($_SESSION['point_earned'])){
    echo "No point_earned available in session";
    exit;
}

// Retrieve and sanitize input values
$id_reservation = $_GET['id_reservation'];
$status = $_GET['status'] ?? null;

// Remove comma from the price (if any) and convert to an integer
$price = (int)str_replace(',', '', $_GET['price']);
$point_earned = $_SESSION['point_earned'] - $price * 2; // Deduct points based on the price
$id_client = $_SESSION['id_client'];

// Establish a database connection
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection error: " . $e->getMessage();
    exit;
}

// Update the reservation status to 'canceled'
$stmt = $db->prepare("UPDATE reservation_client SET status = 'canceled' WHERE id_reservation = ?");
$stmt->execute([$id_reservation]);

// If the status is not 'pending', update the client's points
if ($status != 'pending') {

    // Update the client's earned points in the database
    $stmt = $db->prepare("UPDATE login_client SET point_earned = ? WHERE id_client = ?");
    $result = $stmt->execute([$point_earned, $id_client]);

    // Update the session variable for points earned
    $_SESSION['point_earned'] = $point_earned;
}

// Redirect to the client history reservation page with a success flag
header('location: ../view/client_history_reservation.php?sucess=1');
?>
