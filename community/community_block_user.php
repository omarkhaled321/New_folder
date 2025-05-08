<?php
session_start();

if (isset($_SESSION['email'])) {
    // Establish the database conn
include "../login/config.php";

    $user_email = $_SESSION['email'];
    $action = $_POST['action']; // 'block' or 'unblock'
    $blocked_email = $_POST['user_email']; // Email of the user to be blocked/unblocked

    if ($action === 'block') {
        // Perform blocking
        $blocked_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO blocks (sender_email, receiver_email, blocked_at) VALUES ('$user_email', '$blocked_email', '$blocked_at')";
        if (mysqli_query($conn, $query)) {
            echo "User blocked successfully";
        } else {
            echo "Error blocking user: " . mysqli_error($conn);
        }
    } elseif ($action === 'unblock') {
        // Perform unblocking
        $query = "DELETE FROM blocks WHERE sender_email = '$user_email' AND receiver_email = '$blocked_email'";
        if (mysqli_query($conn, $query)) {
            echo "User unblocked successfully";
        } else {
            echo "Error unblocking user: " . mysqli_error($conn);
        }
    }

    // Close the database conn
    mysqli_close($conn);
} else {
    echo "User not logged in.";
}
?>
