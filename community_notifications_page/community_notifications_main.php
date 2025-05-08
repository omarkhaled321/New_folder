<?php
// Establish database conn
include "../login/config.php";

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $receiver_email = $_SESSION['email'];

    // Query to fetch notifications data for the current user's session
    $notifications_query = "SELECT * FROM notifications WHERE receiver_email = '$receiver_email'";
    $notifications_result = mysqli_query($conn, $notifications_query);

    // Check if query was successful
    if ($notifications_result) {
        echo '<div class="notifications-container">'; // Add a single container element

        // Fetch notifications data into an array
        $notifications_data = mysqli_fetch_all($notifications_result, MYSQLI_ASSOC);

        foreach ($notifications_data as $notification) {
            // Check if the notification is read
            $read_class = $notification['status'] == 'read' ? 'read' : 'bold-text';
            
            echo '<div class="notification ' . $read_class . '" data-content="' . htmlspecialchars($notification['content']) . '" data-id="' . $notification['id'] . '">';
            echo '  <div class="story-section">';
            echo '      <div class="notifications-popup2">';
            echo '          <div>';
            echo '              <div class="profile-pic1">';
            echo '<img src="../profileimg/' . $notification['profile_pic'] . '" >';
            echo '              </div>';
            echo '              <div class="notification-body1">';
            echo '                  <b>' . $notification['username'] . ' ' . $notification['lastname'] . '</b> ' . $notification['content'];
            echo '                  <small class="text-muted1">' . $notification['time'] . '</small>';
            echo '              </div>';
            echo '              <div class="trash-icon" data-id="' . $notification['id'] . '">';
            echo '                  <i class="fas fa-trash-alt"></i>'; // Add a trash icon
            echo '              </div>'; // Close the trash icon container            
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>'; // Close the notification container
        }
    } else {
        echo "Error fetching notifications: " . mysqli_error($conn);
    }
} else {
    echo "User not logged in.";
}

// Close database conn
mysqli_close($conn);
?>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('.notification');
    const fullscreenOverlay = document.createElement('div');
    fullscreenOverlay.className = 'fullscreen-overlay';
    
    const fullscreenContent = document.createElement('div');
    fullscreenContent.className = 'fullscreen-content';
    fullscreenOverlay.appendChild(fullscreenContent);

    document.body.appendChild(fullscreenOverlay);

    notifications.forEach(notification => {
        notification.addEventListener('click', function() {
            const content = this.getAttribute('data-content');
            const notificationId = this.getAttribute('data-id');
            fullscreenContent.innerHTML = content;
            fullscreenOverlay.classList.add('active');
            this.classList.remove('bold-text'); // Remove bold class
            
            // AJAX request to mark notification as read
            markNotificationAsRead(notificationId);
        });

        const trashIcon = notification.querySelector('.trash-icon');
        const notificationId = notification.getAttribute('data-id');

        trashIcon.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent notification click event from firing
            deleteNotification(notificationId);
        });
    });

    fullscreenOverlay.addEventListener('click', function() {
        this.classList.remove('active');
    });

    function markNotificationAsRead(notificationId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'community_update_notification_status.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Notification marked as read.');
            } else {
                console.error('Error marking notification as read.');
            }
        };
        xhr.send('notification_id=' + encodeURIComponent(notificationId));
    }

    function deleteNotification(notificationId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'community_delete_notification.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Notification deleted.');
            const notificationElement = document.querySelector(`.notification[data-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.remove(); // Remove notification from UI
            }
        } else {
            console.error('Error deleting notification.');
        }
    };
    xhr.send('notification_id=' + encodeURIComponent(notificationId));
}

});

</script>

</div>