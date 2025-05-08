<nav class="second-nav">
    <div class="container1">
        <h2 class="logo1">Crazy Sale</h2>
        <div class="search-bar1">
            <i class="uil uil-search"></i>
            <input type="search" placeholder="Search for creators, inspirations and projects"/>
        </div>
        <div class="create1">
            <div class="profile-pic1" id="user-profile-pic">
                <img src="../img/noprofile.jpg" alt="User Profile Picture" />
            </div>
        </div>
</nav>
<div class="container1">
        <div class="left1 mobile-hide" id="sidebar">
            <a class="profile1">
                <div class="sidebar1">
                    <a class="menu-item1 active1" href="../community/community.php">
                      <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                    </a>
                    <a class="menu-item1" href="../community_addfriends_page/community_addfriends_page.php">
                    <span><i class="uil uil-user-plus"></i></span> <h3>Add Friends</h3>
                    </a>
                    <a class="menu-item1" id="notifications" href="../community_notifications_page/community_notifications_page.php">
                        <span><i class="uil uil-bell"><small id="notification-count" class="notification-count1">0</small></i></span> 
                        <h3>Notifications</h3>
                    </a>
                    <a class="menu-item1" id="messages-notifications1"  href="../community_messages/community_messages.php">
                        <i class="uil uil-envelope"><small class="message-count1">0</small></i></span><h3>Messages</h3>
                    </a>
                    <a class="menu-item1" href="../community_bookmarks_page/community_bookmarks_page.php">
                      <span><i class="uil uil-bookmark"></i></span> <h3>Bookmarks</h3>
                    </a>
                    <a class="menu-item1" href="../community_friends_page/community_friends_page.php">
                      <span><i class="ri-group-line" style="margin-left: 40px;"></i></span> <h3>Friends</h3>
                    </a>
                    <a class="menu-item1" href="../community_profile_page/community_profile_page.php">
                      <span><i class="uil uil-user"></i></span> <h3>Profile</h3>
                    </a>
                    <a class="menu-item1" href="../settings/settings.php">
                      <span><i class="uil uil-setting"></i></span> <h3>Settings</h3>
                    </a>
                </a>
            </div>
        </div>
    <script>
        // Toggle the sidebar visibility on mobile when profile picture is clicked
document.getElementById('user-profile-pic').addEventListener('click', function() {
    document.querySelector('.left1').classList.toggle('show');
});

    </script>
    <style>
        /* Hide sidebar by default on mobile */
@media (max-width: 1000px) {
    .left1 {
        display: none;
        margin-top: 200px; /* Adjust this value to position the sidebar lower */

    }
    .left1.show {
        display: block;
    }
}

    </style>
        <script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateNotificationCount() {
            fetch('../community_sidebar/get_notifications_count.php')
                .then(response => response.json())
                .then(data => {
                    if (data.notification_count !== undefined) {
                        const notificationCountElement = document.getElementById('notification-count');
                        notificationCountElement.textContent = data.notification_count;
                    } else {
                        console.error('Error fetching notification count:', data.error);
                    }
                })
                .catch(error => console.error('Error fetching notification count:', error));
        }
        
        // Initial call to update notification count
        updateNotificationCount();
        
        // Periodically update notification count every 5 seconds
        setInterval(updateNotificationCount, 5000);
    });
</script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const user_email = '<?php echo $_SESSION['email']; ?>';
        
            function updateUnreadMessagesCount() {
                fetch('../community_sidebar/get_unread_count.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.unread_count !== undefined) {
                            const unreadCountElement = document.querySelector('.message-count1');
                            unreadCountElement.textContent = data.unread_count;
                            unreadCountElement.style.display = data.unread_count > 0 ? 'inline' : 'none';
                        } else {
                            console.error('Error fetching unread count:', data.error);
                        }
                    })
                    .catch(error => console.error('Error fetching unread count:', error));
            }
        
            // Initial call to update unread messages count
            updateUnreadMessagesCount();
        
            // Periodically update unread messages count every 5 seconds
            setInterval(updateUnreadMessagesCount, 5000);
        });
        </script>
        <?php
        include '../login/config.php';
            
            // Check if email session variable is set
            if(isset($_SESSION['email'])) {
                // Get the email from the session
                $user_email = $_SESSION['email'];
            
                // Query to fetch the image URL based on the user's email
                $query = "SELECT image FROM users WHERE email = '$user_email'";
                $result = mysqli_query($conn, $query);
            
                if ($result) {
                    // Check if any rows were returned
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $image_url = $row['image'];
                    } else {
                        // No rows found for the user's email
                        $image_url = null;
                    }
                } else {
                    // Query execution failed
                    $image_url = null;
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                // Email session variable not set
                $image_url = null;
            }
            
            // Close the database connection
            mysqli_close($conn);
            ?>
            <?php
// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}

// Get the user's email from the session
$user_email = $_SESSION['email'];
include '../login/config.php';
// Fetch user friends' stories
$sql = "
    SELECT su.image, su.email, su.username,
           COUNT(s.id) AS post_count
    FROM friends f
    JOIN users su ON f.friend_email = su.email
    JOIN stories s ON f.friend_email = s.email
    WHERE f.user_email = ? AND f.status = 'accepted'
    GROUP BY f.friend_email
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>