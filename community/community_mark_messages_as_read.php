<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(401); // Unauthorized
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400); // Bad request
    exit();
}

// Retrieve the JSON payload from the request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['user_email']) || !isset($data['friend_email'])) {
    http_response_code(400); // Bad request
    exit();
}

$user_email = $data['user_email'];
$friend_email = $data['friend_email'];

// Ensure that the current user is the receiver
if ($_SESSION['email'] !== $user_email) {
    http_response_code(403); // Forbidden
    exit();
}

// Establish the database conn
include "../login/config.php";

// Update the read_status column to 'read' for messages from friend_email to user_email
$update_query = "UPDATE messages SET read_status = 'read' WHERE receiver_email = '$user_email' AND sender_email = '$friend_email' AND read_status = 'unread'";
$result = mysqli_query($conn, $update_query);

if ($result) {
    http_response_code(200); // OK
} else {
    http_response_code(500); // Internal server error
}

mysqli_close($conn);
?>
