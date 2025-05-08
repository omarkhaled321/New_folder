<?php

session_start(); // Start or resume a session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to index.php after logout
header("Location: ../index/index.php");
exit();
?>
