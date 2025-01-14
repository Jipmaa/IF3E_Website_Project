<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if required session and POST data are present
if (!isset($_SESSION['id_client'])) {
    echo "Id_client is missing";
    exit;
}
if (!isset($_POST['id_accommodation'])) {
    echo "ID_accommodation is missing";
}
if (!isset($_POST['checkin_date'])) {
    echo "Checkin_date is missing";
    exit;
}
if (!isset($_POST['checkout_date'])) {
    echo "Checkout_date is missing";
    exit;
}

// Assign variables for ease of use
$id_client = $_SESSION["id_client"];
$id_accommodation = $_POST['id_accommodation'];
$checkin_date = $_POST["checkin_date"];
$checkout_date = $_POST["checkout_date"];
$special_requests = $_POST["special_requests"] ?? ''; // Optional parameter

// Connect to the database
try {
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    exit;
}

// Check room availability
$req = $db->prepare("SELECT id_accommodation, disponibilities, accommodation_name FROM accommodation WHERE id_accommodation = :id_accommodation");
$req->execute([":id_accommodation" => $id_accommodation]);
$data = $req->fetch();

$accommodation_name = $data['accommodation_name'];

// If no accommodation is found
if (!$data) {
    echo "No accommodation found for the name: $accommodation_name";
    exit;
}

// Check if there are available rooms
if ($data["disponibilities"] <= 0) {
    echo "No availability for this accommodation.";
    exit;
}

$disponibilities = $data["disponibilities"]; // Store remaining availability

// Proceed with booking if rooms are available
if ($disponibilities >= 1) {
    try {
        // Insert booking into the accommodation history table
        $stmt = $db->prepare("INSERT INTO history_accommodation (id_accommodation, checkin_date, checkout_date, special_request) 
        VALUES (:id_accommodation, :checkin_date, :checkout_date, :special_request)");
        $stmt->execute([
            ':id_accommodation' => $id_accommodation,
            ':checkin_date' => $checkin_date,
            ':checkout_date' => $checkout_date,
            ':special_request' => $special_requests
        ]);

        // Retrieve the ID of the inserted booking history
        $stmt = $db->prepare("SELECT id_accommodation_history FROM history_accommodation WHERE id_accommodation = :id_accommodation AND checkin_date = :checkin_date AND checkout_date = :checkout_date");
        $stmt->execute([':id_accommodation' => $id_accommodation, ':checkin_date' => $checkin_date, ':checkout_date' => $checkout_date]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the booking history record was found
        if ($data) {
            $id_history_accommodation = $data['id_accommodation_history'];
        } else {
            echo "No booking found with the specified criteria.";
        }

        // Update room availability
        $stmt = $db->prepare("UPDATE accommodation SET disponibilities = disponibilities - 1 
                              WHERE id_accommodation = :id_accommodation");
        $stmt->execute([':id_accommodation' => $id_accommodation]);

        // Check if availability update was successful
        if ($stmt->rowCount() == 0) {
            echo "Error updating availability.";
            exit;
        }

        // Generate a unique confirmation number for the booking
        $confirmation_numberREQUEST = "SELECT MAX(confirmation_number) AS max_confirmation_number FROM reservation_client";
        $stmt = $db->prepare($confirmation_numberREQUEST);
        $stmt->execute();
        $data = $stmt->fetch();
        $confirmation_number = $data['max_confirmation_number'] + 1;

        // Calculate a random price based on the stay duration
        $price = ($checkin_date - $checkout_date) * rand(20,200);

        // Insert client reservation details
        $stmt = $db->prepare("INSERT INTO reservation_client (id_client, id_history_accommodation, checkin_date, checkout_date, confirmation_number, price)
        VALUES (:id_client, :id_history_accommodation, :checkin_date, :checkout_date, :confirmation_number, :price)");
        $stmt->execute([
            ':id_client' => $id_client,
            ':id_history_accommodation' => $id_history_accommodation,
            ':checkin_date' => $checkin_date,
            ':checkout_date' => $checkout_date,
            ':confirmation_number' => $confirmation_number,
            ':price' => $price
        ]);

        // Check if the client reservation was successfully inserted
        if ($stmt->rowCount() == 0) {
            echo "Error inserting the reservation.";
            exit;
        }

        // Redirect to the accommodation page on successful booking
        header("Location: ../view/client_history_reservation?success=1");
        exit;
    } catch (PDOException $e) {
        // Handle errors during insertion or updates
        echo "Error during booking: " . $e->getMessage();
        header("Location: ../view/accommodation.php?error=insert_failed");
        exit;
    }
} else {
    // If no rooms are available
    echo "No rooms available";
    header("Location: ../view/accommodation.php?error=insert_failed");
    exit;
}
?>
