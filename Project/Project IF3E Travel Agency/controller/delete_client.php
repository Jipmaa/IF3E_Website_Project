<?php
// Enable PHP error reporting for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Establish a connection to the database using PDO
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

// Check if 'id_client' is provided in the URL parameters
if (isset($_GET['id_client'])) {
    $id_client = $_GET['id_client']; // Retrieve the client ID from the URL

    // Prepare the SQL DELETE query to remove the client from the login_client table
    $stmt = $db->prepare("DELETE FROM login_client WHERE id_client = :id_client");
    $stmt->bindParam(':id_client', $id_client); // Bind the client ID to the query

    // Execute the DELETE query
    if ($stmt->execute()) {
        // If the deletion is successful, redirect to the client management page
        header("Location: ../view/staff_clients_management.php");
        exit();
    } else {
        // If an error occurs during execution, display an error message
        echo "<p>Error while deleting the client.</p>";
    }
} else {
    // If 'id_client' is not provided, display an error message
    echo "<p>Client ID is missing.</p>";
}
?>
