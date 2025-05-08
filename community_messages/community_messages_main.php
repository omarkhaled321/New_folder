<div class="container10">
        <div class="left10 mobile-hide">
            <a class="profile1">

            </a>
            <div class="sidebar1">
                <a class="menu-item1 active1" href="../community/community.php">
                  <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                </a>
                <a class="menu-item1 " href="../community_addfriends_page/community_addfriends_page.php">
                <span><i class="uil uil-user-plus"></i></span> <h3>Add Friends</h3>
                </a>
                <a class="menu-item1" id="notifications" href="../community_notifications_page/community_notifications_page.php">
                    <span><i class="uil uil-bell"><small id="notification-count" class="notification-count1">0</small></i></span> 
                    <h3>Notifications</h3>
                </a>

                <a class="menu-item1" id="messages-notifications1"  href="../community_messages_page/community_messages_page.php">
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
            
            </div>
        </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const user_email = '<?php echo $_SESSION['email']; ?>';

    function updateUnreadMessagesCount() {
        fetch('./community_get_unread_count.php')
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
<style>
    .unread_count {
        background-color: lightblue;
        color: white;
        border-radius: 50%;
        padding: 2px 5px;
        font-size: 10px;
        margin-left: 5px;
    }
    .msg_time,.msg_time_send {
    font-size: 12px;
    margin-left: 5px;
    white-space: nowrap;
}
</style>

<?php

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
} else {
    // Redirect the user to the login page or display an error message
    header("Location: ../login/login.php"); // Redirect to the login page
    exit(); // Stop further execution
}

// Establish the database conn
include "../login/config.php";

// Ensure the profileimg folder exists
$profile_img_folder = "../profileimg";
if (!is_dir($profile_img_folder)) {
    mkdir($profile_img_folder);
}

// Fetch friends' information from the database
$search_query = isset($_GET['search']) ? $_GET['search'] : ''; // Get search query from URL parameter
$query = "SELECT friend_email FROM friends WHERE user_email = '$user_email'";

// Modify query to include search filter
if (!empty($search_query)) {
    $query .= " AND (username LIKE '%$search_query%' OR lastname LIKE '%$search_query%')";
}

$result = mysqli_query($conn, $query);

?>

<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-4 col-xl-3 chat" style="margin-left: -250px;">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
                <div class="card-header">
                    <div class="input-group">
                    <input type="text" placeholder="Search..." name="" class="form-control search" id="searchFriend">
                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['email'])) {
                    $user_email = $_SESSION['email'];

                    // Fetch friends' information from the database
                    $query = "SELECT friend_email FROM friends WHERE user_email = '$user_email'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="card-body contacts_body">';
                        echo '<h3>Your Friends</h3>';
                        echo '<ul class="contacts" id="friends-list">';

                        while ($row = mysqli_fetch_assoc($result)) {
                            $friend_email = $row['friend_email'];

                            // Fetch friend's profile information from the signup table
                            $profile_query = "SELECT username, lastname, image FROM users WHERE email = '$friend_email'";
                            $profile_result = mysqli_query($conn, $profile_query);

                            // Check if the user is blocked
                            $block_query = "SELECT * FROM blocks WHERE sender_email = '$user_email' AND receiver_email = '$friend_email'";
                            $block_result = mysqli_query($conn, $block_query);
                            $is_blocked = mysqli_num_rows($block_result) > 0 ? 1 : 0;

                            if (mysqli_num_rows($profile_result) > 0) {
                                $profile_row = mysqli_fetch_assoc($profile_result);
                                $username = $profile_row['username'];
                                $last_name = $profile_row['lastname'];
                                $profile_pic = $profile_row['image'];
                                $image_path = "../profileimg/$profile_pic";

                                // Fetch unread message count
                                $unread_query = "SELECT COUNT(*) AS unread_count FROM messages WHERE sender_email = '$friend_email' AND receiver_email = '$user_email' AND read_status = 'unread'";
                                $unread_result = mysqli_query($conn, $unread_query);
                                $unread_count = mysqli_fetch_assoc($unread_result)['unread_count'];

                                // Display friend's information with a unique id
                                echo '<li class="friend" data-username="' . $username . '" data-lastname="' . $last_name . '" data-image="' . $image_path . '" data-email="' . $friend_email . '" data-is-blocked="' . $is_blocked . '">';
                                echo '<div class="d-flex bd-highlight">';
                                echo '<div class="img_cont">';
                                echo '<img src="../profileimg/' . $image_path . '" class="rounded-circle user_img" alt="Profile Picture">';
                                echo '<span class="online_icon"></span>';
                                echo '</div>';
                                echo '<div class="user_info">';
                                echo '<span>' . $username . ' ' . $last_name;
                                if ($unread_count > 0) {
                                    echo '<span class="unread_count">' . $unread_count . '</span>';
                                }
                                echo '</span>';
                                echo '<p class="last-message">Loading...</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</li>';
                            }
                        }

                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';

                    } else {
                        echo "No friends found.";
                    }
                } else {
                    echo "User not logged in.";
                }
                mysqli_close($conn);
                ?>
            </div>

            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-footer">
                        <form id="mark-as-read-form" style="display: none;">
                            <input type="hidden" name="user_email" value="">
                            <input type="hidden" name="friend_email" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const user_email = '<?php echo $_SESSION['email']; ?>';
    const friends = document.querySelectorAll('.friend');

    // Function to filter friends based on search query
    function filterFriends(searchQuery) {
        friends.forEach(friend => {
            const username = friend.getAttribute('data-username').toLowerCase();
            const lastname = friend.getAttribute('data-lastname').toLowerCase();
            const fullName = username + ' ' + lastname;
            const isMatch = fullName.includes(searchQuery.toLowerCase());

            // Show/hide friend based on search result
            if (isMatch) {
                friend.style.display = 'block';
            } else {
                friend.style.display = 'none';
            }
        });
    }

    // Event listener for changes in the search input
    document.getElementById('searchFriend').addEventListener('input', function() {
        const searchQuery = this.value.trim();
        filterFriends(searchQuery);
    });

    // Initial filter if search input has initial value
    const initialSearchQuery = document.getElementById('searchFriend').value.trim();
    filterFriends(initialSearchQuery);
});

</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const user_email = '<?php echo $_SESSION['email']; ?>';
    const friends = document.querySelectorAll('.friend');

    friends.forEach(friend => {
        const friend_email = friend.getAttribute('data-email');
        
        fetch(`./community_get_last_message.php?user_email=${user_email}&friend_email=${friend_email}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Log the response to check if it's correct

                if (data.message !== 'No messages found.') {
                    const lastMessageElement = friend.querySelector('.last-message');
                    lastMessageElement.textContent = data.message;
                    
                    // Check if the message is unread
                    if (data.read_status === 'unread') {
                        lastMessageElement.classList.add('unread');
                        lastMessageElement.classList.add('blue-text'); // Add class to style text as blue
                    }
                } else {
                    console.error('Error fetching last message:', data.message);
                }
            })
            .catch(error => console.error('Error fetching last message:', error));

        // Event listener for marking messages as read
        friend.addEventListener('click', function() {
            const payload = {
                user_email: user_email,
                friend_email: friend_email
            };

            // Debugging: Log the payload to the console
            console.log('Payload being sent:', payload);

            fetch('./community_mark_messages_as_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update read status');
                }
                console.log('Read status updated successfully');
            })
            .catch(error => console.error('Error updating read status:', error));
        });
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const user_email = '<?php echo $_SESSION['email']; ?>';
    const friends = document.querySelectorAll('.friend');

    // Function to fetch and update unread counts for each friend
    function updateUnreadCounts() {
        friends.forEach(friend => {
            const friend_email = friend.getAttribute('data-email');
            fetch(`./community_get_unread_count.php?user_email=${user_email}&friend_email=${friend_email}`)
                .then(response => response.json())
                .then(data => {
                    const unreadCountElement = friend.querySelector('.unread_count');
                    if (data.unread_count > 0) {
                        unreadCountElement.textContent = data.unread_count;
                        unreadCountElement.style.display = 'inline'; // Show the unread count
                    } else {
                        unreadCountElement.style.display = 'none'; // Hide the unread count if zero
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        });
    }

    // Call the function initially and then every 5 seconds
    updateUnreadCounts();
    setInterval(updateUnreadCounts, 5000); // Update every 5 seconds

    // Event listener to hide the unread count when a friend is clicked
    friends.forEach(friend => {
        friend.addEventListener('click', function() {
            const unreadCountElement = friend.querySelector('.unread_count');
            unreadCountElement.style.display = 'none'; // Hide the unread count
        });
    });
});


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let messageInterval;

    function fetchAndUpdateMessages(receiverEmail) {
        const senderEmail = "<?php echo $_SESSION['email']; ?>";
        const xhrMessages = new XMLHttpRequest();
        xhrMessages.open('POST', './community_fetch_messages.php', true);
        xhrMessages.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhrMessages.onreadystatechange = function() {
            if (xhrMessages.readyState === XMLHttpRequest.DONE) {
                if (xhrMessages.status === 200) {
                    const messages = JSON.parse(xhrMessages.responseText);
                    const chatBody = document.querySelector('.col-md-8.col-xl-6.chat .card .msg_card_body');
                    chatBody.innerHTML = ''; // Clear previous messages

                    const now = new Date();

                    messages.forEach(message => {
                        const messageTime = new Date(message.time);
                        const timeDifference = now - messageTime;
                        const oneDay = 24 * 60 * 60 * 1000;
                        let timeDisplay;

                        if (timeDifference < oneDay) {
                            timeDisplay = messageTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        } else {
                            timeDisplay = messageTime.toLocaleDateString();
                        }

                        const msgContainer = document.createElement('div');
                        msgContainer.className = message.sender_email === senderEmail ? 'd-flex justify-content-end mb-4' : 'd-flex justify-content-start mb-4';
                        const msgContent = document.createElement('div');
                        msgContent.className = message.sender_email === senderEmail ? 'msg_cotainer_send' : 'msg_cotainer';
                        msgContent.textContent = message.message;
                        const msgTime = document.createElement('span');
                        msgTime.className = message.sender_email === senderEmail ? 'msg_time_send' : 'msg_time';
                        msgTime.textContent = timeDisplay;
                        msgContent.appendChild(msgTime);
                        msgContainer.appendChild(msgContent);
                        chatBody.appendChild(msgContainer);
                    });

                    chatBody.scrollTop = chatBody.scrollHeight;
                } else {
                    console.error('Failed to fetch messages:', xhrMessages.status);
                }
            }
        };
        xhrMessages.send(`receiver_email=${encodeURIComponent(receiverEmail)}`);
    }

    document.querySelectorAll('.friend').forEach(function(friend) {
        friend.addEventListener('click', function() {
            clearInterval(messageInterval);

            const username = friend.getAttribute('data-username');
            const lastname = friend.getAttribute('data-lastname');
            const image = friend.getAttribute('data-image');
            const isBlocked = friend.getAttribute('data-is-blocked') === '1';
            const receiverEmail = friend.getAttribute('data-email');

            const blockButtonHtml = isBlocked ? '<i class="fas fa-ban"></i> Unblock' : '<i class="fas fa-ban"></i> Block';

            const chatContainer = document.querySelector('.col-md-8.col-xl-6.chat .card');
            if (chatContainer) {
                chatContainer.innerHTML = `
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="${image}" class="rounded-circle user_img">
                                <span class="online_icon"></span>
                            </div>
                            <div class="user_info">
                                <span>${username} ${lastname}</span>
                            </div>
                            <div class="video_cam"></div>
                        </div>
                        <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                        <div class="action_menu">
                            <ul>
                                <li class="block_button">${blockButtonHtml}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body msg_card_body"></div>
                    <div class="card-footer">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                            </div>
                            <textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
                            <div class="input-group-append">
                                <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                            </div>
                        </div>
                    </div>
                `;

                fetchAndUpdateMessages(receiverEmail);

                messageInterval = setInterval(function() {
                    fetchAndUpdateMessages(receiverEmail);
                }, 5000);

                const blockButton = chatContainer.querySelector('.block_button');
                if (blockButton) {
                    blockButton.addEventListener('click', function() {
                        const action = blockButton.classList.contains('unblock') ? 'unblock' : 'block';
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', './community_block_user.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    if (action === 'block') {
                                        blockButton.innerHTML = '<i class="fas fa-ban"></i> Unblock';
                                        blockButton.classList.add('unblock');
                                    } else {
                                        blockButton.innerHTML = '<i class="fas fa-ban"></i> Block';
                                        blockButton.classList.remove('unblock');
                                    }
                                } else {
                                    console.error('Failed to perform action:', xhr.status);
                                }
                            }
                        };
                        xhr.send(`action=${action}&user_email=${encodeURIComponent(receiverEmail)}`);
                    });
                }

                const sendButton = chatContainer.querySelector('.send_btn');
                if (sendButton) {
                    sendButton.addEventListener('click', function() {
                        const messageInput = chatContainer.querySelector('.type_msg');
                        const message = messageInput.value.trim();
                        if (message !== '') {
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', './community_send_message.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        messageInput.value = '';
                                        fetchAndUpdateMessages(receiverEmail);
                                    } else {
                                        console.error('Failed to send message:', xhr.status);
                                    }
                                }
                            };
                            xhr.send(`receiver_email=${encodeURIComponent(receiverEmail)}&message=${encodeURIComponent(message)}`);
                        }
                    });
                }
            }
        });
    });
});
</script>
</div>
<script>
$(document).ready(function() {
    $(document).on('click', '#action_menu_btn', function() {
        $(this).siblings('.action_menu').toggle();
    });
});

</script>
