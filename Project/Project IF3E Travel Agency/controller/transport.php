<?php
session_start();  // Start the session to access session variables

// Check if required POST variables are set, else show an error message
if(!isset($_SESSION['id_client'])){
    echo "No value for id_client";  // If no client ID in session, output error message
}
if(!isset($_POST['id_transport'])){
    echo "No value for id_transport";  // If no transport ID provided, output error message
}
if(!isset($_POST['departure_date'])){
    echo "No value for departure_date";  // If no departure date provided, output error message
}
if(!isset($_POST['id_seat_preferences'])){
    echo "No value for id_seat_preferences";  // If no seat preference provided, output error message
}
if(!isset($_POST['departure_city'])) {
    echo "No value for departure_city";  // If no departure city provided, output error message
}
if(!isset($_POST['arrival_city'])) {
    echo "No value for arrival_city";  // If no arrival city provided, output error message
}
if(isset($_POST['return_date'])){
    $return_date = $_POST['return_date'];  // If return date is provided, assign it to a variable
}

// Simplifying variable usage by assigning POST data to PHP variables
$id_client = $_SESSION['id_client'];  // Get client ID from session
$id_transport = $_POST['id_transport'];  // Get transport ID from POST data
$departure_date = $_POST['departure_date'];  // Get departure date from POST data
$id_seat_preferences = $_POST['id_seat_preferences'];  // Get seat preference from POST data
$departure_city = $_POST['departure_city'];  // Get departure city from POST data
$arrival_city = $_POST['arrival_city'];  // Get arrival city from POST data

// Define a base price for transportation
$basePrice = 50;

// Initialize the price variable with the base price
$price = $basePrice;

// Calculate the price based on selected cities
if ($departure_city && $arrival_city) {
    // Example conditions to calculate the price based on departure and arrival cities
    if ($departure_city == "Paris" && $arrival_city == "New York" || $departure_city == "New York" && $arrival_city == "Paris") {
        $price = $basePrice + 150;  // Price for Paris <-> New York
    } elseif ($departure_city == "Paris" && $arrival_city == "Tokyo" || $departure_city == "Tokyo" && $arrival_city == "Paris") {
        $price = $basePrice + 200;  // Price for Paris <-> Tokyo
    } elseif ($departure_city == "Paris" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "Paris") {
        $price = $basePrice + 30;  // Price for Paris <-> London
    } elseif ($departure_city == "New York" && $arrival_city == "Tokyo" || $departure_city == "Tokyo" && $arrival_city == "New York") {
        $price = $basePrice + 250;  // Price for New York <-> Tokyo
    } elseif ($departure_city == "New York" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "New York") {
        $price = $basePrice + 100;  // Price for New York <-> London
    } elseif ($departure_city == "Tokyo" && $arrival_city == "London" || $departure_city == "London" && $arrival_city == "Tokyo") {
        $price = $basePrice + 180;  // Price for Tokyo <-> London
    } else {
        $price = $basePrice + 150;  // Default price if no specific city pair matches
    }
}

// Connect to the database
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Set error mode to exception for better error handling

// Check the availability of transport (remaining seats)
$req = $db->prepare("SELECT remaining_place, company_name FROM transportation WHERE id_transport = :id_transport");
$req->execute([":id_transport" => $id_transport]);  // Execute the query with the transport ID
$data = $req->fetch();  // Fetch the result of the query

$remaining_place = $data['remaining_place'];  // Get the number of remaining seats
$company_name = $data['company_name'];  // Get the transport company name

if (!$data) {
    echo "Aucun transport trouvé pour le nom : $company_name";  // If no transport data is found, show an error
    exit;
}

if ($data["remaining_place"] <= 0) {
    echo "Aucune disponibilité pour ce transport.";  // If no remaining seats, show an error
    exit;
}

// Generate a new ticket number for the client by finding the max ticket number in history
$ticket_numberREQUEST = "SELECT MAX(ticket_number) AS max_ticket_number FROM history_transportation";
$stmt = $db->prepare($ticket_numberREQUEST);
$stmt->execute();  // Execute the query
$data = $stmt->fetch();  // Fetch the result
$ticket_number = $data['max_ticket_number'] + 1;  // Increment the max ticket number by 1

// Insert the transportation history into the database
$SQLreq_history = "INSERT INTO history_transportation (id_transport, departure_date, return_date, id_seat_preferences, ticket_number, departure_city, arrival_city)
VALUES (?, ?, COALESCE(?, NULL), ?, ?, ?, ?)";
$stmt = $db->prepare($SQLreq_history);
$stmt->execute([$id_transport, $departure_date, $return_date ?? null, $id_seat_preferences, $ticket_number, $departure_city, $arrival_city]);  // Execute the insert query

// Retrieve the last inserted history record's ID
$id_history_transportREQUEST = "SELECT MAX(id_transport_history) AS max_id_transport_history FROM history_transportation";
$stmt = $db->prepare($id_history_transportREQUEST);
$stmt->execute();  // Execute the query
$data = $stmt->fetch();  // Fetch the result
$id_history_transport = $data['max_id_transport_history'];  // Get the ID of the last inserted record

// Update the transport availability by reducing the remaining seats
$stmt = $db->prepare("UPDATE transportation SET remaining_place = remaining_place - 1 
                              WHERE id_transport = :id_transport");
$stmt->execute([':id_transport' => $id_transport]);  // Execute the update query

// Check if the availability update was successful
if ($stmt->rowCount() == 0) {
    echo "Erreur lors de la mise à jour de la disponibilité.";  // If no rows were affected, show an error
    exit;
}

// Generate a new confirmation number for the reservation
$confirmation_numberREQUEST = "SELECT MAX(confirmation_number) AS max_confirmation_number FROM reservation_client";
$stmt = $db->prepare($confirmation_numberREQUEST);
$stmt->execute();  // Execute the query to fetch the max confirmation number
$data = $stmt->fetch();  // Fetch the result
$confirmation_number = $data['max_confirmation_number'] + 1;  // Increment the max confirmation number by 1

// Insert the reservation into the reservation table
$SQLreq = "INSERT INTO reservation_client (id_client, id_history_transport, checkin_date, checkout_date, confirmation_number, price)
VALUES (?, ?, ?, COALESCE(?, NULL), ?, ?)";
$insertStmt = $db->prepare($SQLreq);

// Execute the insert query with the client ID, transport history ID, dates, confirmation number, and price
if ($insertStmt->execute([$id_client, $id_history_transport, $departure_date, $return_date ?? null, $confirmation_number, $price])) {
    // If the reservation is successful, redirect to the transport page with a success message
    header("Location: ../view/client_history_reservation.php?success=1");
    exit();
} else {
    // If the reservation insert fails, redirect with an error message
    header("Location: ../view/transport.php?error=insert_failed");
    exit();
}

?>
