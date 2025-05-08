<?php
session_start();
include '../login/config.php';
// Check if user is logged in
if (isset($_SESSION['email'])) {
    $receiver_email = $_SESSION['email'];

    // Query to fetch notification count for the current user's session
    $notification_count_query = "SELECT COUNT(*) AS notification_count FROM notifications WHERE receiver_email = '$receiver_email' AND status = 'unread'";
    $notification_count_result = mysqli_query($conn, $notification_count_query);

    // Check if query was successful
    if ($notification_count_result) {
        $notification_count_data = mysqli_fetch_assoc($notification_count_result);
        $notification_count = $notification_count_data['notification_count'];

        // Return the notification count as JSON
        echo json_encode(['notification_count' => $notification_count]);
    } else {
        // Return an error message if query fails
        echo json_encode(['error' => 'Error fetching notification count']);
    }
} else {
    // Return an error message if user is not logged in
    echo json_encode(['error' => 'User not logged in']);
}

// Close database connection
mysqli_close($conn);
?>
