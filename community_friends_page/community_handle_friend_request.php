<?php
// Database connection
include "../login/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $request_id = $_POST['request_id'];

    // Fetch the sender and receiver emails
    $stmt = $conn->prepare("SELECT sender_email, receiver_email FROM friend_requests WHERE id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();
    $stmt->close();

    if ($action === 'accept') {
        // Insert the friendship into the friends table
        $stmt = $conn->prepare("
            INSERT INTO friends (user_email, friend_email, status)
            VALUES (?, ?, 'accepted'), (?, ?, 'accepted')
        ");
        $stmt->bind_param("ssss", $request['sender_email'], $request['receiver_email'], $request['receiver_email'], $request['sender_email']);
        $stmt->execute();
        $stmt->close();

        // Delete the friend request
        $stmt = $conn->prepare("DELETE FROM friend_requests WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();
        
        echo "Friend request accepted";
    } elseif ($action === 'decline') {
        // Handle decline friend request
        $stmt = $conn->prepare("DELETE FROM friend_requests WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->close();
        
        echo "Friend request declined";
    }
}

$conn->close();
?>
