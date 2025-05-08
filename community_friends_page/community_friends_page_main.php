
<?php
// Ensure the user is logged in and the email is stored in the session
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further execution
}

// Get the current user's email from the session
$currentUserEmail = $_SESSION['email'];

// Connect to your database
include "../login/config.php";

// Fetch all users from the 'users' table excluding the current user
$sqlUsers = "SELECT username, lastname, image, email FROM users WHERE email != '$currentUserEmail'";
$resultUsers = $conn->query($sqlUsers);

// Fetch all friends of the current user
$sqlFriends = "SELECT friend_email FROM friends WHERE user_email = '$currentUserEmail'";
$resultFriends = $conn->query($sqlFriends);

$friendEmails = [];
if ($resultFriends->num_rows > 0) {
    while ($row = $resultFriends->fetch_assoc()) {
        $friendEmails[] = $row['friend_email'];
    }
}

// Fetch friend details from the 'users' table
$friendDetails = [];
if (!empty($friendEmails)) {
    $friendEmailsString = "'" . implode("','", $friendEmails) . "'";
    $sqlFriendDetails = "SELECT username, lastname, image, email FROM users WHERE email IN ($friendEmailsString)";
    $resultFriendDetails = $conn->query($sqlFriendDetails);

    if ($resultFriendDetails->num_rows > 0) {
        while ($row = $resultFriendDetails->fetch_assoc()) {
            $friendDetails[] = $row;
        }
    }
}

$users = [];
if ($resultUsers->num_rows > 0) {
    while ($row = $resultUsers->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close the connection
$conn->close();
?>
<?php
// Database connection
include "../login/config.php";


// Assuming the logged-in user's email is stored in a session
$user_email = $_SESSION['email'];

// Fetch friend requests
$sql = "
    SELECT fr.id as request_id, s.username, s.lastname, s.email, s.image 
    FROM friend_requests fr
    JOIN users s ON fr.sender_email = s.email
    WHERE fr.receiver_email = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$friend_requests = [];
while ($row = $result->fetch_assoc()) {
    $friend_requests[] = $row;
}

// Count the number of friend requests
$requestCount = count($friend_requests);

$stmt->close();
?>
<div class="middle1">
    <div class="story-section">
        <div class="messages2">
            <div class="heading1">
                <h4>Friends</h4>
                <span><i class="uil uil-edit"></i></span>
            </div>
  
            <div class="search-bar1">
                <span><i class="uil uil-search"></i></span>
                <input type="search" placeholder="Search Friends" id="message-search1">
            </div>


            <div class="category2">
                <h6 class="active1">Primary</h6>
                <h6>Add Friends</h6>
                <h6 class="message-requests1">Requests(<?php echo $requestCount; ?>)</h6>
            </div>

            <!-- Friends Section -->
            <?php foreach ($friendDetails as $friend): ?>
            <div class="message2">
                <div class="profile-pic1">
                    <img src="../profileimg/<?php echo htmlspecialchars($friend['image']); ?>" alt="Profile Picture">
                    <div class="active1"></div>
                </div>
                <div class="message-body5">
                    <h5><?php echo htmlspecialchars($friend['username'] . ' ' . $friend['lastname']); ?></h5>
                    <div class="button-container5">
                        <button class="btn1 btn-primary1" data-email="<?php echo $friend['email']; ?>">Remove</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Add Friends Section -->
            <div class="add-friends-section">
            <h4>Add Friends</h4>
            <?php foreach ($users as $user): ?>
                <?php
                $isFriend = in_array($user['email'], $friendEmails);
                ?>
                <div class="request1">
                    <form class="add-friend-form" method="post">
                        <input type="hidden" name="receiver_email" value="<?php echo $user['email']; ?>">
                        <div class="info1">
                            <div class="profile-pic1">
                                <!-- Add link to another page with user details as query parameters -->
                                <a href="../community_othersprofile_page/community_othersprofile_page.php?firstname=<?php echo urlencode($user['username']); ?>&lastname=<?php echo urlencode($user['lastname']); ?>&image=<?php echo urlencode($user['image']); ?>">
                                    <img src="../profileimg/<?php echo htmlspecialchars($user['image']); ?>" alt="image">
                                </a>
                            </div>
                            <div>
                                <h5><?php echo htmlspecialchars($user['username']) . ' ' . htmlspecialchars($user['lastname']); ?></h5>
                            </div>
                        </div>
                        <div class="action1">
                            <?php if ($isFriend): ?>
                                <button class="btn1" type="button">Friends</button>
                            <?php else: ?>
                                <button class="btn1 btn-primary1" type="submit" name="add_friend">Add Friend</button>
                            <?php endif; ?>
                            <button class="btn1">Message</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
            </div>

            <!-- Requests Section -->
            <div class="requests-section">
    <h4>Requests</h4>
    <?php foreach ($friend_requests as $request): ?>
        <div class="request1" data-request-id="<?php echo $request['request_id']; ?>">
            <div class="info1">
                <div class="profile-pic1">
                    <img src="../profileimg/<?php echo htmlspecialchars($request['image']); ?>" alt="Profile Picture">
                </div>
                <div>
                    <h5><?php echo htmlspecialchars($request['username'] . ' ' . $request['lastname']); ?></h5>
                    <p class="text-muted1">
                        Mutual friends: <?php echo getMutualFriendsCount($conn, $user_email, $request['email']); ?>
                    </p>
                </div>
            </div>
            <div class="action1">
                <button class="btn1 btn-primary1" onclick="handleFriendRequest('accept', <?php echo $request['request_id']; ?>)">Accept</button>
                <button class="btn1" onclick="handleFriendRequest('decline', <?php echo $request['request_id']; ?>)">Decline</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Hide add friends and requests sections initially
        $('.add-friends-section').hide();
        $('.requests-section').hide();

        // Add click event for Add Friends header
        $('h6:contains("Add Friends")').click(function() {
            $('.add-friends-section').toggle();
            $('.requests-section').hide(); // Hide requests section
            
            // Hide message2 content when clicking on Add Friends
            $('.message2').hide();
        });

        // Add click event for Requests header
        $('h6.message-requests1').click(function() {
            $('.requests-section').toggle();
            $('.add-friends-section').hide(); // Hide add friends section
            
            // Hide message2 content when clicking on Requests
            $('.message2').hide();
        });

        // Add click event for Primary header
        $('h6:contains("Primary")').click(function() {
            // Show message2 content and hide other sections
            $('.message2').show();
            $('.add-friends-section').hide();
            $('.requests-section').hide();
        });

        // Add click event for Remove button

        $(document).on('click', '.btn-primary1', function() {
    var friendEmail = $(this).data('email');
    var $messageElement = $(this).closest('.message2');

    $.ajax({
        url: 'community_remove_friend.php',
        type: 'POST',
        data: {
            friendEmail: friendEmail
        },
        success: function(response) {
            alert(response);
            if (response === "Friend removed successfully") {
                $messageElement.remove();

                // Update local storage to reflect the change
                localStorage.removeItem(friendEmail);

                // Update button status dynamically
                $(".add-friend-form").each(function() {
                    var form = $(this);
                    var receiverEmail = form.find("input[name='receiver_email']").val();

                    if (receiverEmail === friendEmail) {
                        updateFriendRequestButton(form, receiverEmail);
                    }
                });
            }
        },
        error: function() {
            alert("Error: Could not remove friend");
        }
    });
});
    });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const categoryHeaders = document.querySelectorAll('.middle1 .messages2 .category2 h6');

    categoryHeaders.forEach(header => {
        header.addEventListener('click', function() {
            // Remove active class from all headers
            categoryHeaders.forEach(h => h.classList.remove('active1'));
            
            // Add active class to the clicked header
            this.classList.add('active1');
        });
    });
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Function to check and update the friend request button status
        function updateFriendRequestButton(form, receiverEmail) {
            // Check if the receiver email is stored in local storage
            if (localStorage.getItem(receiverEmail) === "requested") {
                form.find("button[type='submit']").text("Cancel Request").addClass("cancel-request");
            }
        }

        // Loop through each add friend form
        $(".add-friend-form").each(function() {
            var form = $(this);
            var receiverEmail = form.find("input[name='receiver_email']").val();

            // Check and update friend request button status
            updateFriendRequestButton(form, receiverEmail);
        });

        $(".add-friend-form").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var receiverEmail = form.find("input[name='receiver_email']").val();

            $.ajax({
                url: "comunity_send_friend_request.php",
                method: "POST",
                data: {
                    receiverEmail: receiverEmail
                },
                success: function(response) {
                    alert(response);
                    form.find("button[type='submit']").text("Cancel Request").addClass("cancel-request");
                    
                    // Store the receiver email and status in local storage
                    localStorage.setItem(receiverEmail, "requested");
                },
                error: function() {
                    alert("Error: Friend request failed to send.");
                }
            });
        });

        $(document).on("click", ".cancel-request", function(e) {
            e.preventDefault();

            var form = $(this).closest("form");
            var receiverEmail = form.find("input[name='receiver_email']").val();

            $.ajax({
                url: "community_cancel_friend_request.php",
                method: "POST",
                data: {
                    receiverEmail: receiverEmail
                },
                success: function(response) {
                    alert(response);
                    form.find("button[type='submit']").text("Add Friend").removeClass("cancel-request");
                    
                    // Remove the receiver email from local storage
                    localStorage.removeItem(receiverEmail);
                },
                error: function() {
                    alert("Error: Unable to cancel friend request.");
                }
            });
        });
    });
    
    </script>

<script>
function handleFriendRequest(action, requestId) {
    // Send AJAX request to handle friend request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "community_handle_friend_request.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            if (xhr.responseText.includes("accepted") || xhr.responseText.includes("declined")) {
                var requestElement = document.querySelector(`[data-request-id='${requestId}']`);
                if (requestElement) {
                    requestElement.remove();
                }
            }
        }
    };
    xhr.send("action=" + action + "&request_id=" + requestId);
}

</script>
<script>
    $(document).ready(function() {
        $('#message-search1').on('input', function() {
            var searchText = $(this).val().toLowerCase();

            $('.message2').each(function() {
                var friendName = $(this).find('.message-body5 h5').text().toLowerCase();

                if (friendName.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });
</script>
</div>