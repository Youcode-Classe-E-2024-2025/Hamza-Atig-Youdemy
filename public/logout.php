<?php
session_start();
session_unset(); // Clears all session variables
session_destroy(); // Destroys the session

// Optionally regenerate the session ID for security
session_start();
session_regenerate_id(true);

header("Location: login.php");
exit();
?>
