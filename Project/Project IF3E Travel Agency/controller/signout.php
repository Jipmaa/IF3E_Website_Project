<?php
// Start the session to access session variables and handle the user's session.
session_start();

// Unset all session variables to clear any stored data.
session_unset();  // Removes all session variables.

// Destroy the current session, effectively logging out the user.
session_destroy();  // Destroys the session and all its data.

header("Location: ../view/menu_client.php");  // Redirect the user to the client menu page after logging out.
exit;  // Ensure no further code is executed after the redirect.
?>
