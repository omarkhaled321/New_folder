<?php
// Establish database conn
include "../login/config.php";
// Check if notification ID is provided
if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];

    // Update the status of the notification to "read" in the database
    $update_query = "UPDATE notifications SET status = 'read' WHERE id = $notification_id";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Status updated successfully
        echo "Notification marked as read.";
    } else {
        // Error updating status
        echo "Error marking notification as read: " . mysqli_error($conn);
    }
} else {
    // Notification ID not provided
    echo "Notification ID not provided.";
}

// Close database conn
mysqli_close($conn);
?>
