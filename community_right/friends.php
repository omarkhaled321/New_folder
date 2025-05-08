<?php
include '../login/config.php';

// Function to get mutual friends count
function getMutualFriendsCount($conn, $user_email, $friend_email) {
    $sql = "
        SELECT COUNT(*) as mutual_count
        FROM friends AS f1
        JOIN friends AS f2 ON f1.friend_email = f2.friend_email
        WHERE f1.user_email = ? AND f2.user_email = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_email, $friend_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['mutual_count'];
}

// Assuming the logged-in user's email is stored in a session
$user_email = $_SESSION['email'];

// Fetch friend requests
$sql = "
    SELECT fr.id as request_id, s.username, s.email, s.image 
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

$stmt->close();
?>

<!-- HTML part to display friend requests -->
<div class="friend-requests1">
    <h4>Requests</h4>
    <?php foreach ($friend_requests as $request): ?>
        <div class="request1">
            <div class="info1">
                <div class="profile-pic1">
                    <img src="profileimg/<?php echo htmlspecialchars($request['image']); ?>" alt="Profile Picture">
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
        <script>
function handleFriendRequest(action, requestId) {
    // Send AJAX request to handle friend request
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "community_handle_friend_request.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            location.reload();
        }
    };
    xhr.send("action=" + action + "&request_id=" + requestId);
}
</script>