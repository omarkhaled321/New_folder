<?php
session_start();
header('Content-Type: application/json');

// Database connection details
include "../login/config.php";

// Ensure the user is logged in and their email is set in the session
if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$email = $_SESSION['email'];

// Fetch the user's profile picture from the database
$sql = "SELECT image FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image);
    mysqli_stmt_fetch($stmt);

    if ($image) {
        // Return the image path as a JSON response
        $profilePictureUrl = '../profileimg/' . htmlspecialchars($image);
        echo json_encode(['profilePictureUrl' => $profilePictureUrl]);
    } else {
        echo json_encode(['error' => 'Profile picture not found']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Query preparation failed: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
