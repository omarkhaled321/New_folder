<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location:../login/login.php");
    exit;
}

$currentUserEmail = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['receiverEmail'])) {
    $receiverEmail = $_POST['receiverEmail'];

    // Connect to your database
include "../login/config.php";

    // Get current user's profile picture path from session
    $currentUserPicPath = "../profileimg/". $_SESSION['image'];

    // Check if friend request already exists
    $sqlCheckRequest = "SELECT * FROM friend_requests WHERE sender_email = '$currentUserEmail' AND receiver_email = '$receiverEmail'";
    $result = $conn->query($sqlCheckRequest);

    if ($result->num_rows == 0) {
        // Insert friend request into friend_requests table with status "pending"
        $sqlInsertRequest = "INSERT INTO friend_requests (sender_email, receiver_email, status) VALUES ('$currentUserEmail', '$receiverEmail', 'pending')";

        if ($conn->query($sqlInsertRequest) === TRUE) {
            echo "Friend request sent successfully.";

            // Fetch sender's username and lastname
            $sqlSenderInfo = "SELECT username, lastname FROM users WHERE email = '$currentUserEmail'";
            $senderInfoResult = $conn->query($sqlSenderInfo);
            $senderInfo = $senderInfoResult->fetch_assoc();

            // Create notification content
            $content = "You have a new friend request from ". $senderInfo['username']. " ". $senderInfo['lastname'];

            // Insert notification into notifications table with current timestamp and current user's profile picture path
            $sqlInsertNotification = "INSERT INTO notifications (username, lastname, sender_email, receiver_email, content, profile_pic, time, status) 
                                      VALUES ('". $senderInfo['username']. "', '". $senderInfo['lastname']. "', '$currentUserEmail', '$receiverEmail', '$content', '$currentUserPicPath', NOW(), 'unread')";

            $conn->query($sqlInsertNotification);

        } else {
            echo "Error: Unable to send friend request.";
        }
    } else {
        echo "Friend request already sent.";
    }

    $conn->close();
}
?>
