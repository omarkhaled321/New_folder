<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Unauthorized access!']);
    http_response_code(401);
    exit();
}

$user_email = $_SESSION['email'];
$friend_email = $_GET['friend_email'] ?? '';

// Validate friend email
if (empty($friend_email)) {
    echo json_encode(['error' => 'Invalid friend email!']);
    http_response_code(400);
    exit();
}

include "../login/config.php";

$query = "
    SELECT sender_email, receiver_email, message, time 
    FROM messages 
    WHERE (sender_email = '$user_email' AND receiver_email = '$friend_email') 
       OR (sender_email = '$friend_email' AND receiver_email = '$user_email')
    ORDER BY time ASC
";

$result = mysqli_query($conn, $query);

$messages = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($messages);
?>
