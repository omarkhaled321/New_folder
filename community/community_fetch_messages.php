<?php
session_start();
include "../login/config.php";

if(isset($_SESSION['email']) && isset($_POST['receiver_email'])) {
    $senderEmail = $_SESSION['email'];
    $receiverEmail = $_POST['receiver_email'];
    
    // Fetch messages from the database
    $query = "SELECT * FROM messages WHERE (sender_email = '$senderEmail' AND receiver_email = '$receiverEmail') OR (sender_email = '$receiverEmail' AND receiver_email = '$senderEmail') ORDER BY time ASC";
    $result = mysqli_query($conn, $query);
    
    // Prepare the messages array
    $messages = array();
    while($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    // Output JSON response
    echo json_encode($messages);
} else {
    echo "Unauthorized access!";
}

// Close the database conn
mysqli_close($conn);
?>
