<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in.']);
    exit;
}

$story_id = $_POST['story_id'];
$user_email = $_SESSION['email'];

include "../login/config.php";

// Check if the record already exists
$sql = "SELECT * FROM story_views WHERE story_id = ? AND user_email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("SQL Prepare Error: " . $conn->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Prepare Error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("is", $story_id, $user_email);
if (!$stmt->execute()) {
    error_log("SQL Execute Error: " . $stmt->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Execute Error: ' . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Record exists, update the status
    $sql = "UPDATE story_views SET status = 'read' WHERE story_id = ? AND user_email = ?";
} else {
    // Record does not exist, insert new record
    $sql = "INSERT INTO story_views (story_id, user_email, status) VALUES (?, ?, 'read')";
}

$stmt->close();
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("SQL Prepare Error: " . $conn->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Prepare Error: ' . $conn->error]);
    exit;
}

$stmt->bind_param("is", $story_id, $user_email);
if (!$stmt->execute()) {
    error_log("SQL Execute Error: " . $stmt->error);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'SQL Execute Error: ' . $stmt->error]);
    exit;
}

echo json_encode(['success' => 'Story status updated.']);

$conn->close();
?>
