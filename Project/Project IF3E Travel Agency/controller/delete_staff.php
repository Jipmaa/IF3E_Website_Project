<?php
// Enable PHP error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Establish a connection to the database using PDO
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

// Check if 'id_employee' is provided in the URL parameters
if (isset($_GET['id_employee'])) {
    $id_employee = $_GET['id_employee']; // Retrieve the employee ID from the URL

    // Prepare the SQL DELETE query to remove the employee from the login_staff table
    $stmt = $db->prepare("DELETE FROM login_staff WHERE id_employee = :id_employee");
    $stmt->bindParam(':id_employee', $id_employee); // Bind the employee ID to the query

    // Execute the DELETE query
    if ($stmt->execute()) {
        // If the deletion is successful, redirect to the staff management page with a success message
        header("Location: ../view/staff_staff_management.php?success=1");
        exit();
    } else {
        // If an error occurs during execution, display an error message
        echo "<p>Error while deleting the employee.</p>";
        exit();
    }
} else {
    // If 'id_employee' is not provided, display an error message
    echo "Employee ID is missing.";
    exit();
}
?>
