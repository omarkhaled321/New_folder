

<?php

include "../login/config.php";

// Retrieve session email (assuming it's stored in $_SESSION['email'])
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Fetch notifications for the session email as receiver
if (!empty($email)) {
    $query = "SELECT * FROM main_notifications WHERE reciever_email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $rowCount = mysqli_num_rows($result);

        // Count unread notifications
        $queryZero = "SELECT * FROM main_notifications WHERE reciever_email = '$email' AND is_read = 0";
        $resultZero = mysqli_query($conn, $queryZero);

        $rowCountZero = mysqli_num_rows($resultZero);
    } else {
        $rowCount = 0;
        $rowCountZero = 0;
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle case where session email is not set
    $rowCount = 0;
    $rowCountZero = 0;
}

// Close connection
$conn->close();
?>
<style>
    .noti {
    position: relative;
    margin-bottom: 10px; /* Adjust margin as needed */
    padding: 10px; /* Adjust padding as needed */
}

.delete-icon {
    position: absolute;
    bottom: 5px; /* Adjust distance from bottom */
    right: 5px; /* Adjust distance from right */
    cursor: pointer; /* Optional: Add cursor pointer for hover effect */
    color: red;
}

</style>

<div class="related-products">
    <div class="container">
        <div class="wrapper">
            <div class="column">
                <div class="products main flexwrap">
                    <div class="not-block">
                        <div id="main">
                            <div id="nott">Notifications <span id="count"><?php echo $rowCountZero; ?></span> out of <?php echo $rowCount; ?></div>
                            <span id="read-all">Mark all as read</span>
                        </div>

                        <?php
                        if ($rowCount > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $readClass = $row['is_read'] ? 'read' : '';
                                $redDotDisplay = $row['is_read'] ? 'none' : 'inline';
                                echo '<div class="noti ' . $readClass . '" data-id="' . $row['id'] . '">';
                                echo '<div class="post">';
                                echo '<div class="name"><span class="imp">' . $row['name'] . '</span> ' . $row['content'] . ' <span class="red-dot" style="display: ' . $redDotDisplay . '">&#128308;</span></div>';
                                echo '<div class="time">' . $row['time'] . '</div>';
                                echo '</div>';
                                echo '<div class="delete-icon" data-id="' . $row['id'] . '"><i class="ri-delete-bin-line"></i></div>'; // Added data-id attribute for identification
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="noti">';
                            echo '<div class="post">';
                            echo '<div class="name">No notifications found</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <div id="zoomedInContainer" class="zoomed-in" style="display: none;">
                        <div class="zoomed-in-content" id="zoomedInContent"></div>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        $('.delete-icon').on('click', function() {
                            var notificationId = $(this).data('id'); // Get the notification ID from data-id attribute
                            var confirmation = confirm('Are you sure you want to delete this notification?'); // Confirmation dialog
                    
                            if (confirmation) {
                                $.ajax({
                                    url: 'delete_notification.php', // Replace with your PHP script that handles deletion
                                    method: 'POST',
                                    data: { id: notificationId },
                                    success: function(response) {
                                        // Optionally, remove the notification from the UI on success
                                        $('.noti[data-id="' + notificationId + '"]').remove();
                                        alert('Notification deleted successfully.');
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Error deleting notification.');
                                        console.error(error);
                                    }
                                });
                            }
                        });
                    });
                    </script>

                    <script src="../js/main_notifications.js"></script>
                    <script>
                        function markAsRead(notificationId = null) {
                            const xhr = new XMLHttpRequest();
                            const url = './update_notifications.php';
                            xhr.open('POST', url, true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                            let params = notificationId ? `action=mark_read&id=${notificationId}` : `action=mark_all_read`;

                            xhr.send(params);

                            xhr.onload = function() {
                                if (xhr.status == 200) {
                                    console.log('Notification marked as read');
                                    const countElement = document.getElementById('count');
                                    if (notificationId) {
                                        countElement.innerText = Math.max(parseInt(countElement.innerText) - 1, 0);
                                    } else {
                                        countElement.innerText = 0;
                                    }
                                } else {
                                    console.error('Error marking notification as read');
                                }
                            };
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            const notificationElements = document.querySelectorAll('.noti');
                            const main = document.getElementById("read-all");

                            notificationElements.forEach(notification => {
                                const nameElement = notification.querySelector('.name');
                                const content = nameElement.innerHTML;
                                const notificationId = notification.dataset.id;

                                nameElement.addEventListener('click', () => {
                                    const zoomedInContent = document.createElement('div');
                                    zoomedInContent.innerHTML = content;

                                    document.getElementById('zoomedInContent').innerHTML = zoomedInContent.outerHTML;

                                    document.getElementById('zoomedInContainer').style.display = 'flex';

                                    markAsRead(notificationId);

                                    notification.classList.add('read');
                                    const redDot = notification.querySelector('.red-dot');
                                    if (redDot) {
                                        redDot.style.display = 'none';
                                    }
                                });
                            });

                            main.addEventListener("click", function() {
                                notificationElements.forEach(notification => {
                                    notification.classList.add("read");
                                    const redDot = notification.querySelector(".red-dot");
                                    if (redDot) {
                                        redDot.style.display = "none";
                                    }
                                });
                                document.getElementById("count").innerText = 0;

                                markAsRead();
                            });

                            const icon = document.querySelector(".icon.ri-dashboard-line");
                            const container = document.querySelector(".container1");

                            icon.addEventListener("click", function() {
                                container.classList.toggle("active");
                            });
                        });

                        document.getElementById('zoomedInContainer').addEventListener('click', (event) => {
                            if (event.target === document.getElementById('zoomedInContainer')) {
                                document.getElementById('zoomedInContainer').style.display = 'none';
                            }
                        });
                    </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>