<?php

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Get user's email
    $email = $_SESSION['email'];

    // Database connection details
    include "../login/config.php";

    // Prepare and execute SQL query to fetch unread notifications for the user
    $stmt = $conn->prepare("SELECT * FROM main_notifications WHERE reciever_email = ? AND is_read = 0 ORDER BY id DESC LIMIT 5");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any unread notifications
    if ($result->num_rows > 0) {
        // Loop through each notification and display
        while ($row = $result->fetch_assoc()) {
            // Determine the read class and red dot display
            $readClass = $row['is_read'] ? 'read' : '';
            $redDotDisplay = $row['is_read'] ? 'none' : 'inline';

            // Output the notification item with lines between them
            echo '<li class="iscart ishover notification-item">';
            echo '<div class="icon-large"><i class="ri-notification-line"></i></div>';
            echo '<div class="notification-content">';
            echo '<div class="name"><span class="imp">' . $row['name'] . '</span> ' . $row['content'] . ' <span class="red-dot" style="display: ' . $redDotDisplay . '">&#128308;</span></div>';
            echo '<div class="time">' . $row['time'] . '</div>';
            echo '</div>';
            echo '</li>';
            echo '<li class="noti-line"></li>'; // Add line between notifications
        }
    } else {
        // If no unread notifications found, display a message
        echo '<li class="noti">';
        echo '<div class="post">';
        echo '<div class="name">No new notifications</div>';
        echo '</div>';
        echo '</li>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If user is not logged in, handle accordingly (you can customize this based on your app logic)
    echo '<li class="noti">';
    echo '<div class="post">';
    echo '<div class="name">Please log in to view notifications</div>';
    echo '</div>';
    echo '</li>';
}

?>
<style>
    /* General Styles */
@import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap");

:root {
  --blue: #2a2185;
  --white: #fff;
  --gray: #f5f5f5;
  --black1: #222;
  --black2: #999;
}


.notification-item {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 10px;
  border-bottom: 1px solid #ccc; /* Line between notifications */
}

.notification-item:last-child {
  border-bottom: none; /* Remove line after the last notification */
}


.notification-content {
  flex: 1;
}

.name {
  font-size: 16px; /* Adjust font size as needed */
  overflow: hidden;
  padding: 4px;
}

.imp {
  font-weight: bold;
  color: black;
}

.red-dot {
  display: inline-block;
  font-size: 14px; /* Adjust font size for red dot */
  margin-left: 5px; /* Adjust margin for red dot */
}

.time {
  color: rgb(15, 15, 15);
  font-size: 12px; /* Adjust font size as needed */
}


</style>