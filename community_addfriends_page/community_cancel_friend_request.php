<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit;
}

$currentUserEmail = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['receiverEmail'])) {
    $receiverEmail = $_POST['receiverEmail'];

    // Connect to your database
include "../login/config.php";

    // Delete friend request
    $sqlDeleteRequest = "DELETE FROM friend_requests WHERE sender_email = '$currentUserEmail' AND receiver_email = '$receiverEmail'";

    if ($conn->query($sqlDeleteRequest) === TRUE) {
        // Delete notification for canceled friend request
        $sqlDeleteNotification = "DELETE FROM notifications WHERE sender_email = '$currentUserEmail' AND receiver_email = '$receiverEmail'";
        
        if ($conn->query($sqlDeleteNotification) === TRUE) {
            echo "Friend request cancelled.";
        } else {
            echo "Error deleting notification: " . $conn->error;
        }
    } else {
        echo "Error deleting friend request: " . $conn->error;
    }

    $conn->close();
}
?>
