<?php

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_email = $_SESSION['email'];

// Establish the database conn
include "../login/config.php";

// Fetch friends' profile information
$query = "
    SELECT f.friend_email, s.username, s.lastname, s.image 
    FROM friends f 
    JOIN users s ON f.friend_email = s.email 
    WHERE f.user_email = '$user_email'
";
$result = mysqli_query($conn, $query);

$friends = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $friends[] = $row;
    }
}

mysqli_close($conn);
?>
<?php
// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_email = $_SESSION['email'];

// Establish the database conn
include "../login/config.php";

$friends = []; // Initialize an empty array to store unique friend entries

foreach ($result as $row) {
    $friend_email = $row['friend_email'];

    // Fetch last message for each friend
    $last_message_query = "SELECT * FROM messages WHERE (sender_email = '$friend_email' AND receiver_email = '$user_email') OR (sender_email = '$user_email' AND receiver_email = '$friend_email') ORDER BY time DESC LIMIT 1";
    $last_message_result = mysqli_query($conn, $last_message_query);

    if ($last_message_result && mysqli_num_rows($last_message_result) > 0) {
        $last_message_row = mysqli_fetch_assoc($last_message_result);
        $last_message = $last_message_row['message'];
        $read_status = $last_message_row['read_status'];
    } else {
        $last_message = 'No messages found.';
        $read_status = ''; // No need to set read status if there's no last message
    }

    // Add friend entry to the array
    $friend = [
        'friend_email' => $friend_email,
        'username' => $row['username'],
        'lastname' => $row['lastname'],
        'image' => $row['image'],
        'last_message' => $last_message,
        'read_status' => $read_status
    ];

    // Check if the friend is already in the array based on email
    $existing_friend_key = array_search($friend_email, array_column($friends, 'friend_email'));

    if ($existing_friend_key === false) {
        // Friend not found in the array, add it
        $friends[] = $friend;
    } else {
        // Friend already exists in the array, update last message if necessary
        $existing_last_message = $friends[$existing_friend_key]['last_message'];
        if ($existing_last_message === 'No messages found.' && $last_message !== 'No messages found.') {
            $friends[$existing_friend_key]['last_message'] = $last_message;
            $friends[$existing_friend_key]['read_status'] = $read_status;
        }
    }
}
?>

<style>
    #chat-container {
        width: 100%; /* Adjust this value as needed */
        max-width: 70rem; /* Optional max width */
        margin-top: 40px;
    }
    .msg_time,.msg_time_send {
    font-size: 12px;
    margin-left: 5px;
    white-space: nowrap;
}
</style>
<div class="right1">
    <div class="messages1">
        <div class="heading">
            <h4>Messages</h4>
        </div>

        <div class="search-bar1">
            <span><i class="uil uil-search"></i></span>
            <input type="search" placeholder="Search Messages" id="message-search">
        </div>

        <div class="category1">
            <h6 class="active1">Primary</h6>
        </div>
        <!-- ================================================================== -->
        <?php foreach ($friends as $friend): ?>
<?php
    // Fetch last message and unread count
    $friend_email = $friend['friend_email'];
    $last_message_query = "SELECT message, read_status FROM messages WHERE sender_email = '$friend_email' AND receiver_email = '$user_email' ORDER BY time DESC LIMIT 1";
    $last_message_result = mysqli_query($conn, $last_message_query);
    $last_message_row = mysqli_fetch_assoc($last_message_result);
    $last_message = $last_message_row['message'];
    $read_status = $last_message_row['read_status'];

    // Count unread messages
    $unread_count_query = "SELECT COUNT(*) AS unread_count FROM messages WHERE sender_email = '$friend_email' AND receiver_email = '$user_email' AND read_status = 'unread'";
    $unread_count_result = mysqli_query($conn, $unread_count_query);
    $unread_count = mysqli_fetch_assoc($unread_count_result)['unread_count'];
?>

<div class="message1" data-email="<?php echo htmlspecialchars($friend['friend_email']); ?>" data-username="<?php echo htmlspecialchars($friend['username']); ?>" data-lastname="<?php echo htmlspecialchars($friend['lastname']); ?>" data-image="<?php echo htmlspecialchars($friend['image']); ?>">
    <div class="profile-pic1">
        <img src="../profileimg/<?php echo htmlspecialchars($friend['image']); ?>" alt="Profile Picture">
        <div class="active1"></div>
    </div>
    <div class="message-body1">
        <h5><?php echo htmlspecialchars($friend['username']) . ' ' . htmlspecialchars($friend['lastname']); ?></h5>
        <?php if ($unread_count > 0): ?>
            <p class="text-bold"><?php echo $unread_count . " New Messages"; ?></p>
        <?php else: ?>
            <p class="text-bold"><?php echo $last_message; ?></p>
        <?php endif; ?>
    </div>
</div>

<?php endforeach; ?>


    </div>

<!-- Chat container -->
<div class="col-md-8 col-xl-6 chat" id="chat-container" style="display: none;">
    <div class="card">
        <div class="card-header msg_head">
            <div class="d-flex bd-highlight">
                <div class="img_cont">
                    <img src="" class="rounded-circle user_img" id="chat-profile-img">
                    <span class="online_icon"></span>
                </div>
                <div class="user_info">
                    <span id="chat-username"></span>
                </div>
                <div class="video_cam"></div>
            </div>
            <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
            <div class="action_menu">
                <ul>
                    <li class="block_button"><i class="fas fa-ban"></i> Block</li>
                </ul>
            </div>
        </div>
        <div class="card-body msg_card_body" id="chat-messages"></div>
        <div class="card-footer">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                </div>
                <textarea name="" class="form-control type_msg" placeholder="Type your message..." id="chat-input"></textarea>
                <div class="input-group-append">
                    <span class="input-group-text send_btn" id="send-message-btn"><i class="fas fa-location-arrow"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// JavaScript to handle friend click and open chat

document.addEventListener("DOMContentLoaded", function() {
    const user_email = '<?php echo $_SESSION['email']; ?>';
    const friends = document.querySelectorAll('.message1');
    const actionMenuBtn = document.getElementById('action_menu_btn');
    const actionMenu = document.querySelector('.action_menu');
    const blockButton = document.querySelector('.block_button');
    let currentFriendEmail = '';

    friends.forEach(friend => {
    friend.addEventListener('click', function() {
        currentFriendEmail = friend.getAttribute('data-email');
        const username = friend.getAttribute('data-username');
        const lastname = friend.getAttribute('data-lastname');
        const image = friend.getAttribute('data-image');

        // Update chat container with friend's info
        document.getElementById('chat-username').textContent = `${username} ${lastname}`;
        document.getElementById('chat-profile-img').src = `../profileimg/${image}`;
        
        // Display chat container
        document.getElementById('chat-container').style.display = 'block';

        // Fetch and display chat messages
        fetchChatMessages(user_email, currentFriendEmail);

        // Mark messages as read
        markMessagesAsRead(user_email, currentFriendEmail);

        // Send message button handler
        document.getElementById('send-message-btn').onclick = function() {
            sendMessage(user_email, currentFriendEmail);
        };

        // Check block status
        checkBlockStatus(currentFriendEmail);
    });
});

function markMessagesAsRead(user_email, friend_email) {
    const requestData = {
        user_email: user_email,
        friend_email: friend_email
    };

    fetch('community_mark_messages_as_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        if (response.ok) {
            console.log('Messages marked as read successfully.');
            // Update the UI to remove the "1 New Message" indicator
            const friendElement = document.querySelector(`.message1[data-email="${friend_email}"]`);
            if (friendElement) {
                friendElement.querySelector('.text-bold').textContent = ''; // Remove the text content
            }
        } else {
            console.error('Failed to mark messages as read:', response.status);
        }
    })
    .catch(error => console.error('Error marking messages as read:', error));
}




function fetchChatMessages(user_email, friend_email) {
    fetch(`community_fetch_sidebar_messages.php?user_email=${user_email}&friend_email=${friend_email}`)
        .then(response => response.json())
        .then(messages => {
            const chatMessagesContainer = document.getElementById('chat-messages');
            chatMessagesContainer.innerHTML = '';

            messages.forEach(message => {
                const messageElement = document.createElement('div');
                messageElement.className = message.sender_email === user_email ? 'd-flex justify-content-end mb-4' : 'd-flex justify-content-start mb-4';

                // Format the time
                const messageTime = new Date(message.time);
                const hours = messageTime.getHours();
                const minutes = messageTime.getMinutes();
                const ampm = hours >= 12 ? 'PM' : 'AM';
                const formattedTime = `${hours % 12 || 12}:${minutes < 10 ? '0' : ''}${minutes} ${ampm}`;

                const messageContent = `
                    <div class="${message.sender_email === user_email ? 'msg_cotainer_send' : 'msg_cotainer'}">
                        ${message.message}
                        <span class="${message.sender_email === user_email ? 'msg_time_send' : 'msg_time'}">${formattedTime}</span>
                    </div>
                `;
                messageElement.innerHTML = messageContent;
                chatMessagesContainer.appendChild(messageElement);
            });

            chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;

            // Update the UI to show the last message
            const friendElement = document.querySelector(`.message1[data-email="${friend_email}"]`);
            if (friendElement) {
                friendElement.querySelector('.text-bold').textContent = messages.length > 0 ? messages[messages.length - 1].message : ''; // Display the last message
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
}


    function sendMessage(user_email, friend_email) {
        const messageInput = document.getElementById('chat-input');
        const message = messageInput.value.trim();

        if (message !== '') {
            fetch('community_send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `receiver_email=${encodeURIComponent(friend_email)}&message=${encodeURIComponent(message)}`
            })
            .then(response => {
                if (response.ok) {
                    messageInput.value = '';
                    fetchChatMessages(user_email, friend_email);
                } else {
                    console.error('Failed to send message:', response.status);
                }
            })
            .catch(error => console.error('Error sending message:', error));
        }
    }

    // Toggle action menu visibility
    actionMenuBtn.addEventListener('click', function() {
        if (actionMenu.style.display === 'none' || actionMenu.style.display === '') {
            actionMenu.style.display = 'block';
        } else {
            actionMenu.style.display = 'none';
        }
    });

    // JavaScript for handling block/unblock functionality
    blockButton.addEventListener('click', function() {
        const action = this.classList.contains('unblock') ? 'unblock' : 'block';

        fetch('community_block_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=${action}&user_email=${encodeURIComponent(currentFriendEmail)}`
        })
        .then(response => {
            if (response.ok) {
                if (action === 'block') {
                    this.innerHTML = '<i class="fas fa-ban"></i> Unblock';
                    this.classList.add('unblock');
                } else {
                    this.innerHTML = '<i class="fas fa-ban"></i> Block';
                    this.classList.remove('unblock');
                }
            } else {
                console.error('Failed to perform action:', response.status);
            }
        })
        .catch(error => console.error('Error performing action:', error));
    });

    function checkBlockStatus(friendEmail) {
        fetch(`community_check_block_status.php?friend_email=${encodeURIComponent(friendEmail)}`)
            .then(response => response.json())
            .then(data => {
                if (data.is_blocked) {
                    blockButton.innerHTML = '<i class="fas fa-ban"></i> Unblock';
                    blockButton.classList.add('unblock');
                } else {
                    blockButton.innerHTML = '<i class="fas fa-ban"></i> Block';
                    blockButton.classList.remove('unblock');
                }
            })
            .catch(error => console.error('Error checking block status:', error));
    }

    // Hide action menu when clicking outside of it
    document.addEventListener('click', function(event) {
        if (!actionMenu.contains(event.target) && !actionMenuBtn.contains(event.target)) {
            actionMenu.style.display = 'none';
        }
    });

});
</script>