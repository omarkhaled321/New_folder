<?php
// Establish database conn
include "../login/config.php";

// Check if notification_id is set and not empty
if (isset($_POST['notification_id']) && !empty($_POST['notification_id'])) {
    $notificationId = $_POST['notification_id'];

    // Query to delete notification from the database
    $delete_query = "DELETE FROM notifications WHERE id = '$notificationId'";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        // Notification deleted successfully
        echo "Notification deleted.";
    } else {
        // Error deleting notification
        echo "Error deleting notification: " . mysqli_error($conn);
    }
} else {
    // Notification ID not provided
    echo "Notification ID not provided.";
}

// Close database conn
mysqli_close($conn);
?>
