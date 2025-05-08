<?php
session_start();
include '../login/config.php'; // Make sure this file includes the code to connect to your database

$user_email = $_SESSION['email'];
$friend_email = $_GET['friend_email'];

$sql = "SELECT blocked_at FROM blocks WHERE sender_email = ? AND receiver_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $user_email, $friend_email);
$stmt->execute();
$result = $stmt->get_result();
$is_blocked = $result->num_rows > 0 ? true : false;

echo json_encode(['is_blocked' => $is_blocked]);
?>
