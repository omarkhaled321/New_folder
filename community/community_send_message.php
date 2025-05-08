<?php
session_start();

if (isset($_SESSION['email'])) {
    // Establish the database conn
include "../login/config.php";

    $sender_email = $_SESSION['email'];
    $receiver_email = $_POST['receiver_email'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if either user has blocked the other
    $block_check_query = "
        SELECT * FROM blocks 
        WHERE (sender_email = '$sender_email' AND receiver_email = '$receiver_email')
        OR (sender_email = '$receiver_email' AND receiver_email = '$sender_email')";
    $block_check_result = mysqli_query($conn, $block_check_query);

    if (mysqli_num_rows($block_check_result) > 0) {
        echo "Message sending failed: user is blocked.";
    } else {
        // Insert the message into the messages table with 'unread' status
        $send_message_query = "
            INSERT INTO messages (sender_email, receiver_email, message, time, read_status) 
            VALUES ('$sender_email', '$receiver_email', '$message', NOW(), 'unread')";
        if (mysqli_query($conn, $send_message_query)) {
            echo "Message sent successfully";

            // Get the sender's username, lastname, and profile picture
            $sender_query = "SELECT username, lastname, image FROM users WHERE email = '$sender_email'";
            $sender_result = mysqli_query($conn, $sender_query);
            $sender_data = mysqli_fetch_assoc($sender_result);

            // Insert the notification into the notifications table
            $notification_content = "{$sender_data['username']} {$sender_data['lastname']} sent you a message: $message";

            $notification_query = "
                INSERT INTO notifications (username, lastname, sender_email, receiver_email, content, time, profile_pic, status) 
                VALUES ('{$sender_data['username']}', '{$sender_data['lastname']}', '$sender_email', '$receiver_email', '$notification_content', NOW(), '{$sender_data['image']}', 'unread')";            
            if (mysqli_query($conn, $notification_query)) {
                echo "Notification sent successfully";
            } else {
                echo "Error sending notification: " . mysqli_error($conn);
            }
        } else {
            echo "Error sending message: " . mysqli_error($conn);
        }
    }

    // Close the database conn
    mysqli_close($conn);
} else {
    echo "User not logged in.";
}
?>
