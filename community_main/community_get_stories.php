<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in.']);
    exit;
}

// Get the friend's email from the URL parameter
$friend_email = $_GET['friend_email'];
error_log("Fetching stories for friend_email: " . $friend_email);

// Database connection
include "../login/config.php";

// Fetch all stories for the given friend's email
$sql = "
    SELECT s.id, s.title, s.photo, s.type, s.profile_pic, s.name
    FROM stories s
    WHERE s.email = ?
    ORDER BY s.id ASC
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("SQL Prepare Error: " . $conn->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Prepare Error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $friend_email);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    error_log("SQL Execute Error: " . $stmt->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Execute Error: ' . $stmt->error]);
    exit;
}

$stories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stories[] = $row; // Include 'profile_pic' and 'name' in the JSON response
    }
} else {
    error_log("No stories found for friend_email: " . $friend_email);
}

header('Content-Type: application/json');
echo json_encode($stories);

$conn->close();
?>
