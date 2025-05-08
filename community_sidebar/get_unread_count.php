<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_email = $_SESSION['email'];
include '../login/config.php';

$query = "SELECT COUNT(*) AS unread_count FROM messages WHERE receiver_email = '$user_email' AND read_status = 'unread'";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    echo json_encode(['unread_count' => $data['unread_count']]);
} else {
    echo json_encode(['error' => 'Failed to fetch unread count']);
}

mysqli_close($conn);
?>