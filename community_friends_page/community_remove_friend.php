<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "Not logged in";
    exit;
}

// Get the current user's email from the session
$currentUserEmail = $_SESSION['email'];

// Database connection
include "../login/config.php";

// Handle friend removal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['friendEmail'])) {
    $friendEmail = $_POST['friendEmail'];

    // Prepare and execute SQL statement to remove the friend
    $sql = "DELETE FROM friends WHERE (user_email = ? AND friend_email = ?) OR (user_email = ? AND friend_email = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $currentUserEmail, $friendEmail, $friendEmail, $currentUserEmail);

    if ($stmt->execute()) {
        echo "Friend removed successfully";
    } else {
        echo "Error: Could not remove friend";
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
