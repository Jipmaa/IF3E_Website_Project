<?php
// Enable PHP error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify that all required fields are provided
    if (!isset($_POST["email"])) {
        echo "Email is missing!";
        exit();
    }

    if (!isset($_POST["name"])) {
        echo "Name is missing!";
        exit();
    }

    if (!isset($_POST["first_name"])) {
        echo "First name is missing!";
        exit();
    }

    if (!isset($_POST["birthdate"])) {
        echo "Birthdate is missing!";
        exit();
    }

    if (!isset($_POST["id_employee"])) {
        echo "Employee ID is missing!";
        exit();
    }

    if (!isset($_POST["phone_number"])) {
        echo "Phone number is missing!";
        exit();
    }

    // Retrieve and sanitize input data
    $email = strtolower(trim($_POST["email"])); // Lowercase and trim email
    $name = ucwords(strtolower($_POST["name"])); // Capitalize name
    $first_name = ucwords(strtolower(trim($_POST["first_name"]))); // Capitalize and trim first name
    $birthdate = $_POST["birthdate"]; // Retrieve birthdate
    $id_employee = $_POST["id_employee"]; // Retrieve employee ID
    $phone_number = $_POST["phone_number"]; // Retrieve phone number
    $role = $_POST["role"]; // Retrieve role

    // Check if a password has been provided (indicates a change of password)
    if (!empty($_POST["password"])) {
        // Hash the new password using BCRYPT
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    } else {
        // If no new password is provided, retain the existing password
        // Connect to the database
        $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        // Prepare SQL query to fetch the current password for the employee
        $stmt = $db->prepare("SELECT password FROM login_staff WHERE id_employee = :id_employee");
        $stmt->bindParam(':id_employee', $id_employee, PDO::PARAM_INT);
        $stmt->execute();
        $staff = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($staff) {
            $password = $staff['password']; // Keep the existing password
        } else {
            // If the employee does not exist, show an error message
            echo "Error: Staff not found.";
            exit();
        }
    }

    // Establish a connection to the database
    $db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

    // Prepare the SQL query to update the staff member's information
    $req = $db->prepare("UPDATE login_staff 
                         SET email = :email, 
                             name = :name, 
                             first_name = :first_name, 
                             password = :password, 
                             birthdate = :birthdate, 
                             phone_number = :phone_number, 
                             role = :role 
                         WHERE id_employee = :id_employee");

    // Execute the query with the provided data
    $req->execute([
        ':email' => $email,
        ':name' => $name,
        ':first_name' => $first_name,
        ':password' => $password,
        ':birthdate' => $birthdate,
        ':id_employee' => $id_employee,
        ':phone_number' => $phone_number,
        ':role' => $role
    ]);

    // Redirect to the staff management page after updating the information
    header("Location: ../view/staff_staff_management.php");
    exit();
} else {
    // If the request method is not POST, redirect to the login page
    header("Location: ../view/login_staff.php");
    exit();
}
?>
