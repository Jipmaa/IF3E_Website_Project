<?php
session_start();

// Enable error messages to assist with debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if all required POST parameters are set
if(!isset($_SESSION['id_client'])){
    echo "No value for id_client";
}
if(!isset($_POST['id_transport'])){
    echo "No value for id_transport";
}
if(!isset($_POST['departure_date'])){
    echo "No value for departure_date";
}
if(!isset($_POST['id_seat_preferences'])){
    echo "No value for id_seat_preferences";
}
if(!isset($_POST['departure_city'])) {
    echo "No value for departure_city";
}
if(!isset($_POST['arrival_city'])) {
    echo "No value for arrival_city";
}
if(!isset($_POST['return_date'])){
    echo "No value for return_date";
}
if (!isset($_POST['id_accommodation'])) {
    echo "ID_accommodation missing";
}

// Simplify variable usage by assigning POST values to local variables
$id_client = $_SESSION['id_client'];
$id_transport = $_POST['id_transport'];
$departure_date = $_POST['departure_date'];
$id_seat_preferences = $_POST['id_seat_preferences'];
$departure_city = $_POST['departure_city'];
$arrival_city = $_POST['arrival_city'];
$return_date = $_POST['return_date'];
$id_accommodation = $_POST['id_accommodation'];
$special_requests = $_POST["special_requests"] ?? ''; // Optional parameter

// Convert dates to DateTime objects to perform date calculations
$departureDate = new DateTime($departure_date);
$returnDate = new DateTime($return_date);

// Calculate the duration between the departure and return dates
$duration = $departureDate->diff($returnDate)->days;

// Base price for the transportation (with a 25% discount)
$basePrice = 50;

// Initialize the calculated price with the base price
$price = $basePrice;

// Calculate the price based on the selected cities
if ($departure_city && $arrival_city) {
    // Example conditions to calculate price based on city pairs
    if ($departure_city == "Paris" && $arrival_city == "New York" || $departure_city == "New York" && $arrival_city == "Paris") {
        $price = $basePrice + 150; // Example price for Paris <-> New York
    } elseif ($departure_city == "Paris" && $arrival_city == "Tokyo" || $departure_city == "Tokyo" && $arrival_city == "Paris") {
        $price = $basePrice + 200; // Example price for Paris <-> Tokyo
    } elseif ($departure_city == "Paris" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "Paris") {
        $price = $basePrice + 30; // Example price for Paris <-> London
    } elseif ($departure_city == "New York" && $arrival_city == "Tokyo" || $departure_city == "Tokyo" && $arrival_city == "New York") {
        $price = $basePrice + 250; // Example price for New York <-> Tokyo
    } elseif ($departure_city == "New York" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "New York") {
        $price = $basePrice + 100; // Example price for New York <-> London
    } elseif ($departure_city == "Tokyo" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "Tokyo") {
        $price = $basePrice + 180; // Example price for Tokyo <-> London
    } else {
        $price = $basePrice + 150; // Default price if no specific match
    }
}

// Connect to the database using PDO
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check the availability of the selected transport
$req = $db->prepare("SELECT remaining_place, company_name FROM transportation WHERE id_transport = :id_transport");
$req->execute([":id_transport" => $id_transport]);
$data = $req->fetch();

// Retrieve the remaining places and company name from the transport data
$remaining_place = $data['remaining_place'];
$company_name = $data['company_name'];

// Handle cases where no transport was found or if no availability exists
if (!$data) {
    echo "No transport found for the name: $company_name";
    exit;
}

if ($data["remaining_place"] <= 0) {
    echo "No availability for this transport.";
    exit;
}

// Check the availability of the selected accommodation
$req = $db->prepare("SELECT id_accommodation, disponibilities, accommodation_name FROM accommodation WHERE id_accommodation = :id_accommodation");
$req->execute([":id_accommodation" => $id_accommodation]);
$data = $req->fetch();

// Retrieve the accommodation name and availability data
$accommodation_name = $data['accommodation_name'];

// Handle cases where no accommodation was found or if no availability exists
if (!$data) {
    echo "No accommodation found for the name: $accommodation_name";
    exit;
}

if ($data["disponibilities"] <= 0) {
    echo "No availability for this accommodation.";
    exit;
}

// Store remaining availability for accommodation
$disponibilities = $data["disponibilities"];

try {
    // Insert the accommodation booking into the history_accommodation table
    $stmt = $db->prepare("INSERT INTO history_accommodation (id_accommodation, checkin_date, checkout_date, special_request) 
        VALUES (:id_accommodation, :checkin_date, :checkout_date, :special_request)");
    $stmt->execute([
        ':id_accommodation' => $id_accommodation,
        ':checkin_date' => $departure_date,
        ':checkout_date' => $return_date,
        ':special_request' => $special_requests
    ]);

    // Retrieve the history record ID for the accommodation
    $stmt = $db->prepare("SELECT id_accommodation_history FROM history_accommodation WHERE id_accommodation = :id_accommodation AND checkin_date = :checkin_date AND checkout_date = :checkout_date");
    $stmt->execute([':id_accommodation' => $id_accommodation, ':checkin_date' => $departure_date, ':checkout_date' => $return_date]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no matching history record is found, exit with an error
    if ($data) {
        $id_history_accommodation = $data['id_accommodation_history'];
    } else {
        echo "No booking found with the specified criteria.";
        exit();
    }

    // Update the availability of the accommodation
    $stmt = $db->prepare("UPDATE accommodation SET disponibilities = disponibilities - 1 
                              WHERE id_accommodation = :id_accommodation");
    $stmt->execute([':id_accommodation' => $id_accommodation]);

    // Check if the availability update was successful
    if ($stmt->rowCount() == 0) {
        echo "Error updating the availability.";
        exit;
    }

    // Generate a confirmation number for the reservation
    $confirmation_numberREQUEST = "SELECT MAX(confirmation_number) AS max_confirmation_number FROM reservation_client";
    $stmt = $db->prepare($confirmation_numberREQUEST);
    $stmt->execute();
    $data = $stmt->fetch();
    $confirmation_number = $data['max_confirmation_number'] + 1;
} catch (PDOException $e) {
    // If an error occurs during the insertion or update process
    echo "Error during reservation: " . $e->getMessage();
    header("Location: ../view/package.php?error=insert_failed");
    exit;
}

// Generate a random price based on the duration
$price = $duration * rand(20, 200) * 0.90;

// Generate a ticket number for the client
$ticket_numberREQUEST = "SELECT MAX(ticket_number) AS max_ticket_number FROM history_transportation";
$stmt = $db->prepare($ticket_numberREQUEST);
$stmt->execute();
$data = $stmt->fetch();
$ticket_number = $data['max_ticket_number'] + 1;

// Insert transportation history data into the history_transportation table
$SQLreq_history = "INSERT INTO history_transportation (id_transport, departure_date, return_date, id_seat_preferences, ticket_number, departure_city, arrival_city)
VALUES (?, ?, COALESCE(?, NULL), ?, ?, ?, ?)";
$stmt = $db->prepare($SQLreq_history);
$stmt->execute([$id_transport, $departure_date, $return_date ?? null, $id_seat_preferences, $ticket_number, $departure_city, $arrival_city]);

// Retrieve the latest transportation history record ID
$id_history_transportREQUEST = "SELECT MAX(id_transport_history) AS max_id_transport_history FROM history_transportation";
$stmt = $db->prepare($id_history_transportREQUEST);
$stmt->execute();
$data = $stmt->fetch();
$id_history_transport = $data['max_id_transport_history'];

// Update the availability of the transport
$stmt = $db->prepare("UPDATE transportation SET remaining_place = remaining_place - 1 
                              WHERE id_transport = :id_transport");
$stmt->execute([':id_transport' => $id_transport]);

// Check if the transport availability update was successful
if ($stmt->rowCount() == 0) {
    echo "Error updating the availability.";
    exit;
}

// Insert data into the travel_package table
$SQLreq_insert_package = "INSERT INTO travel_package (id_transport_history, id_accommodation_history, duration) VALUES (?, ?, ?)";
$stmt = $db->prepare($SQLreq_insert_package);
$stmt->execute([$id_history_transport, $id_history_accommodation, $duration]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve the latest travel package ID
$id_travel_package = "SELECT MAX(id_package) AS max_id_package FROM travel_package";
$stmt = $db->prepare($id_travel_package);
$stmt->execute();
$data = $stmt->fetch();
$id_travel_package = $data['max_id_package'];

// Generate a confirmation number for the reservation
$confirmation_numberREQUEST = "SELECT MAX(confirmation_number) AS max_confirmation_number FROM reservation_client";
$stmt = $db->prepare($confirmation_numberREQUEST);
$stmt->execute();
$data = $stmt->fetch();
$confirmation_number = $data['max_confirmation_number'] + 1;

// Insert the reservation into the reservation_client table
$SQLreq = "INSERT INTO reservation_client (id_client, id_history_transport, id_history_accommodation, id_package, checkin_date, checkout_date, confirmation_number, price)
VALUES (?, ?, ?, ?, ?, COALESCE(?, NULL), ?, ?)";
$insertStmt = $db->prepare($SQLreq);

// If the reservation was successfully inserted, redirect with a success message
if ($insertStmt->execute([$id_client, $id_history_transport, $id_history_accommodation, $id_travel_package, $departure_date, $return_date ?? null, $confirmation_number, $price])) {
    $data = $insertStmt->fetch();
    header("Location: ../view/client_history_reservation.php?success=1");
    exit();
} else {
    // In case of failure, redirect with an error message
    header("Location: ../view/package.php?error=insert_failed");
    exit();
}
?>
