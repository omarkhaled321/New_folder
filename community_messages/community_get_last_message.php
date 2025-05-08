<?php
// Establish the database conn
include "../login/config.php";

if (isset($_GET['user_email']) && isset($_GET['friend_email'])) {
    $user_email = $_GET['user_email'];
    $friend_email = $_GET['friend_email'];

    // Fetch the last message details
    $message_query = "SELECT message, time, read_status FROM messages WHERE (sender_email = '$user_email' AND receiver_email = '$friend_email') OR (sender_email = '$friend_email' AND receiver_email = '$user_email') ORDER BY time DESC LIMIT 1";
    $message_result = mysqli_query($conn, $message_query);

    if (mysqli_num_rows($message_result) > 0) {
        $message_row = mysqli_fetch_assoc($message_result);
        echo json_encode([
            'message' => $message_row['message'],
            'time' => $message_row['time'],
            'read_status' => $message_row['read_status']
        ]);
    } else {
        echo json_encode([
            'message' => 'No messages found.'
        ]);
    }
} else {
    echo json_encode([
        'message' => 'Invalid request.'
    ]);
}

mysqli_close($conn);
?>
