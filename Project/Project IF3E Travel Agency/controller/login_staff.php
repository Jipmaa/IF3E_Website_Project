<?php
// Reset session to avoid conflicts by unsetting and destroying the previous session, then starting a new one.
session_unset();  // Clears all session variables.
session_destroy();  // Destroys the session.
session_start();  // Starts a new session.

// Check if the required POST parameters (email and password) are provided.
// If not, exit the script.
if (!isset($_POST["email"]))  // If email is not provided in the POST request.
    return;  // Stop the execution of the script.

if (!isset($_POST["password"]))  // If password is not provided in the POST request.
    return;  // Stop the execution of the script.

// Clean and assign the input email and password to variables.
$email = strtolower(trim($_POST["email"]));  // Clean the email by trimming whitespace and converting to lowercase.
$password = $_POST["password"];  // Directly assign the password from POST.

// Connect to the database using PDO.
$db = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");  // Connect to MySQL using PDO with the given credentials.

// Prepare the SQL query to check if the provided email exists in the login_staff table.
$req = $db->prepare("SELECT email, password FROM login_staff WHERE email = ?");  // Prepare the query to fetch email and password from the database.

// Execute the prepared statement with the provided email.
$req->execute([$email]);  // Execute the query using the provided email.

$data = $req->fetch();  // Fetch the result from the database.

if ($data && password_verify($password, $data['password'])) {  // Check if data is returned and if the provided password matches the stored password using password_verify.
    // If valid, start a session and store the staff member's information.
    $_SESSION["email"] = $email;  // Store the email in the session.
    $_SESSION["first_name"] = $data["first_name"];  // Store the first name of the staff member in the session.
    $_SESSION["id_employee"] = $data["id_employee"];  // Store the employee ID in the session.
    $_SESSION["role"] = $data["role"];  // Store the role in the session.

    // Redirect the user to the staff client's management page after successful login.
    header("Location: ../view/staff_clients_management.php");  // Redirect to the staff client's management page.
    exit();  // Ensure no further code is executed after the redirect.
} else {
    // If the email or password is incorrect, show an error message and redirect back to the login page with an error parameter.
    echo "Email or password incorrect.";  // Print error message.
    header("Location: ../view/login_staff.php?error=email/password");  // Redirect to the login page with an error message in the query string.
}
?>
