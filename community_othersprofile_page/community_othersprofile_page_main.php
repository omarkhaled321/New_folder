<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve query parameters
$firstName = $_GET['firstname'] ?? '';
$lastName = $_GET['lastname'] ?? '';
$profilePic = $_GET['image'] ?? '';

// Connect to your database (replace with your actual database credentials)
include "../login/config.php";

// Query the number of posts for the user
$stmtPostCount = $conn->prepare("SELECT COUNT(*) AS postCount FROM posts WHERE name = ?");
$stmtPostCount->bind_param("s", $firstName);
$stmtPostCount->execute();
$resultPostCount = $stmtPostCount->get_result();

// Fetch the post count
if ($resultPostCount->num_rows > 0) {
    $rowPostCount = $resultPostCount->fetch_assoc();
    $postCount = $rowPostCount['postCount'];
} else {
    $postCount = 0;
}

// Query the number of friends for the clicked user
$stmtFriendCount = $conn->prepare("SELECT COUNT(*) AS friendCount FROM friends WHERE user_email = ?");
$stmtFriendCount->bind_param("s", $email); // Assuming email is stored in the 'email' field
$stmtFriendCount->execute();
$resultFriendCount = $stmtFriendCount->get_result();

// Fetch the friend count
if ($resultFriendCount->num_rows > 0) {
    $rowFriendCount = $resultFriendCount->fetch_assoc();
    $friendCount = $rowFriendCount['friendCount'];
} else {
    $friendCount = 0;
}

// Close the statements
$stmtPostCount->close();
$stmtFriendCount->close();

// Close the connection
$conn->close();
?>


<div class="middle1">
    <div class="story-section">
        <div class="card1">
            <div class="lines"></div>
            <div class="imgBx">
                <img src="../profileimg/<?php echo $profilePic; ?>" alt="image">
            </div>
            <div class="content">
                <div class="details">
                    <h2><?php echo htmlspecialchars($firstName) ; ?><br><span><?php echo htmlspecialchars($lastName); ?></span></h2>
                    <div class="data">
                        <h3><?php echo $postCount; ?> <span>posts</span></h3>
                        <h3><?php echo $friendCount; ?> <span>Friends</span></h3>
                    </div>
                    <div class="actionBtn">
                        <button>Add Friend</button>
                        <button>Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
<form class="create-post1">
    <div class="profile-pic1">
    <a href="../community_profile_page/community_profile_page.php"> <!-- Change 'profile.php' to the desired page -->
        <img src="<?php echo $profilePictureUrl; ?>" alt="User Profile Picture">
    </a>                    </div>
    <div class="post-icon2">
        <a href="#" style="background: #ffebed;" onclick="showGallery(event)">
        <i style="background: #ff4154;" class="fa-solid fa-camera"></i>
        Gallery</a>
        
        <a href="#" style="background: #fff4d1;"  onclick="showFeeling(event)">
        <i style="background: #ffca28;" class="fa-solid fa-face-grin-beam"></i>
        Feeling / Activity</a>

    </div>
</form>
<form action="community_send_gallery.php" method="post" enctype="multipart/form-data" style="display: none;" id="galleryForm">
    <div class="feeds1" id="gallery">
        <div class="feed1">
            <div class="head1">
                <div class="image-container" style="width: 200px; height: 300px; position: relative;">
                    <i class="ri-add-box-line" id="add-button2" style="cursor: pointer;"></i>
                    <input type="file" class="form-control-file" id="product_image" name="image" accept="image/*,video/*" style="opacity: 0; position: absolute; width: 100%; height: 100%; top: 0; left: 0; cursor: pointer;" onchange="previewImage(this)">
                    <img id="image-preview" src="#" alt="Preview" style="display: none; width: auto; height: auto;">
                </div>
                <div class="search-bar2" >
                    <input type="input" name="title" placeholder=" Enter Title"/>
                </div>
                <div class="search-bar3"  >
                    <textarea placeholder="Enter description" name="description"></textarea>
                </div>
                <input type="submit" value="Post" class="btn2 btn-primary2">
            </div>
        </div>
    </div>
</form>
<form action="community_send_gallery.php" method="post" enctype="multipart/form-data" style="display: none;" id="feelingForm">
    <div class="feeds1" id="feeling">
        <div class="feed1">
            <div class="head1">
                <div class="search-bar4"  >
                    <textarea placeholder="Enter description" name="description"></textarea>
                </div>
                <input type="submit" value="Post" class="btn2 btn-primary2">
            </div>
        </div>
    </div>
</form>

<!-- feeds================================================================================= -->
<?php
// Connect to your database
include "../login/config.php";

// Fetch the user's email from the database based on their name and profile picture
$firstName = $_GET['firstname'] ?? '';
$lastName = $_GET['lastname'] ?? '';
$profilePic = $_GET['image'] ?? '';

$sqlUser = "SELECT email FROM users WHERE username = ? AND lastname = ? AND image = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param('sss', $firstName, $lastName, $profilePic);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    $userEmail = $user['email'];

    // Fetch posts of the user
    $sqlPosts = "SELECT * FROM posts WHERE email = ? ORDER BY time DESC";
    $stmtPosts = $conn->prepare($sqlPosts);
    $stmtPosts->bind_param('s', $userEmail);
    $stmtPosts->execute();
    $resultPosts = $stmtPosts->get_result();

    if ($resultPosts->num_rows > 0) {
        while ($row = $resultPosts->fetch_assoc()) {
        echo '<div class="feeds1">';
        echo '    <div class="feed1">';
        echo '        <div class="head1">';
        echo '            <!-- Head content, if any -->';
        echo '        </div>';
        echo '        <div class="user1">';
        echo '            <div class="profile-pic1">';
        // Fetch the user's profile picture URL from the database and display it
        $profilePicPath = '../profileimg/' . $row['profile_pic']; // Adjust the path as necessary
        echo '                <img src="' . htmlspecialchars($profilePicPath) . '" alt="">';
        echo '            </div>';
        echo '            <div class="info1">';
        echo '                <h3>' . htmlspecialchars($row["name"]) . '</h3>';
        echo '                <small>' . htmlspecialchars($row["time"]) . '</small>';
        echo '            </div>';
        echo '            <span class="edit1" onclick="toggle3Dots(' . $row["id"] . ')" style="cursor: pointer;"><i class="uil uil-ellipsis-h"></i></span>';
        echo '            <div class="feeds2" id="dots_' . $row["id"] . '" style="display: none;">';
        echo '                <div class="feed2">';
        echo '                    <div class="head2">';
        echo '                        <button class="btn1 btn-primary1" style="display: block; margin-bottom: 10px;">Copy Link</button>';
        echo '                        <button class="btn1 btn-primary1" style="display: block;">Report</button>';
        echo '                    </div>';
        echo '                </div>';
        echo '            </div>';
        echo '        </div>';
        // Construct the image path based on the filename stored in the database
        $imagePath = '../profileimg/' . $row['image'];
        echo '        <div class="photo1">';
        echo '            <img class="feed-image" src="' . htmlspecialchars($imagePath) . '" alt="">';
        echo '        </div>';
        echo '        <div class="action-button1">';
        echo '            <div class="interaction-button1">';
        echo "                <span class='heart-icon' data-product-id='" . $row["id"] . "' data-heart-state='unfilled' data-name='" . htmlspecialchars($row["name"]) . "' data-profile-pic='" . htmlspecialchars($profilePicPath) . "'><a href='#'><i class='ri-heart-line'></i></a></span>";
        echo '                <span style="font-size: 20px; cursor: pointer;" id="commentIcon_' . $row["id"] . '" onclick="toggleComments(' . $row["id"] . ')"><i class="uil uil-comment"></i></span>';
        echo '                <span style="font-size: 20px; cursor: pointer;"><i class="uil uil-share"></i></span>';
        echo '            </div>';
        echo '  <div class="share-options">';
        echo '  <p class="title">share</p>';
        echo '  <div class="social-media">';
        echo '      <button class="social-media-btn"><i class="far fa-folder-open"></i></button>';
        echo '      <button class="social-media-btn"><i class="fab fa-whatsapp"></i></button>';
        echo '      <button class="social-media-btn"><i class="fab fa-instagram"></i></button>';
        echo '      <button class="social-media-btn"><i class="fab fa-twitter"></i></button>';
        echo '      <button class="social-media-btn"><i class="fab fa-facebook-f"></i></button>';
        echo '      <button class="social-media-btn"><i class="fab fa-linkedin-in"></i></button>';
        echo '  </div>';
        echo '<div class="link-container" id="linkContainer_' . $row["id"] . '">';
        echo '    <p class="link">http://localhost/projects/quickcart/community.php?id=' . $row["id"] . '</p>'; // Link to the community page with post ID as parameter
        echo '    <button class="copy-btn" onclick="copyLink(' . $row["id"] . ')">copy</button>';
        echo '</div>';
        
        echo '  </div>';
        echo '<div class="feeds3" id="commentsSection_' . $row["id"] . '" style="display: none;">';
        echo '    <div class="feed3">';
        echo '        <div class="comments-wrapper">'; // Add a wrapper for the comments and the form
        
        // Fetch comments from the 'comments' table ordered by time in descending order
        $sqlComments = "SELECT * FROM comments WHERE post_id = ? ORDER BY time DESC";
        $stmtComments = $conn->prepare($sqlComments);
        $stmtComments->bind_param('i', $row['id']);
        $stmtComments->execute();
        $resultComments = $stmtComments->get_result();
        
        if ($resultComments->num_rows > 0) {
            // Output data of each comment
            while ($comment = $resultComments->fetch_assoc()) {
                echo '<div class="user1" style="margin-top: 20px;">'; // Add margin-top style here
                echo '    <div class="profile-pic1">';
                // Display the commenter's profile picture
                $commenterProfilePicPath = '../profileimg/' . $comment['profile_pic']; // Adjust the path as necessary
                echo '        <img src="' . htmlspecialchars($commenterProfilePicPath) . '" alt="">';
                echo '    </div>';
                echo '    <div class="info1">';
                echo '        <h3>' . htmlspecialchars($comment["name"]) . '</h3>';
                echo '        <p>' . htmlspecialchars($comment["comment"]) . '</p>'; // Display the comment content
                echo '        <small>' . htmlspecialchars($comment["time"]) . '</small>';
                echo '        <span style="font-size: 20px; cursor: pointer;"><i class="uil uil-comment"></i></span>';
                echo '        <span style="font-size: 20px; cursor: pointer;"><i class="uil uil-share"></i></span>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            echo "No comments yet.";
        }
        
        echo '        </div>'; // Close the wrapper div
        echo '        <form class="create-post3" action="community_send_comment.php" method="post">'; // Form moved out of the wrapper div
        echo "            <input type='hidden' name='post_id' value='" . $row['id'] . "'>"; // Passing post_id to the form
        echo "            <input type='hidden' name='name' value='" . htmlspecialchars($sessionUsername) . "'>"; // Passing name to the form
        echo "            <input type='hidden' name='profile_pic' value='" . htmlspecialchars($sessionProfilePic) . "'>"; // Passing profile_pic to the form        
        echo '            <div class="profile-pic3">';
        echo '                <img src="../img/profile-8.jpg" alt="">';
        echo '            </div>';
        echo "            <input type='hidden' name='post_id' value='" . $row['id'] . "'>"; // Passing post_id to the form
        echo '            <input type="submit" value="Post" class="btn1 btn-primary1">';
        echo '        </form>';
        
        echo '    </div>';
        echo '</div>';
        

// Assuming this PHP block is within a loop fetching rows
echo '<div class="bookmark1">';
echo '<span class="bookmark-icon" 
    bookmark-product-id="' . $row["id"] . '" 
    data-bookmark-state="unfilled" 
    data-name="' . htmlspecialchars($row["name"]) . '" 
    data-profile-pic="' . htmlspecialchars($profilePicPath) . '" 
    data-post-time="' . htmlspecialchars($row["time"]) . '"
    data-post-image="' . htmlspecialchars($row['image']) . '">
    <a href="#"><i class="ri-bookmark-line"></i></a>
</span>';
echo '</div>';
        echo '        </div>';
// Inside the while loop where you are displaying posts
$postId = $row['id'];

// Query to fetch users who liked the post
$sqlLikes = "SELECT * FROM likedposts WHERE post_id = $postId";
$resultLikes = $conn->query($sqlLikes);

echo '<div class="liked-by1">';
if ($resultLikes && $resultLikes->num_rows > 0) {
    // Displaying users who liked the post
    while ($like = $resultLikes->fetch_assoc()) {
        $profilePicPath = '../profileimg/' . $like['profile_pic']; // Adjust the path as necessary

        echo '<span><img src="' . htmlspecialchars($profilePicPath) . '" alt=""></span>';
    }
    // You can adjust the text based on the number of likes
    echo '<p>Liked by ';
    $resultLikes->data_seek(0); // Reset result pointer to fetch the first row
    $firstLike = $resultLikes->fetch_assoc();
    echo '<b>' . htmlspecialchars($firstLike["name"]) . '</b>';
    // Check if there are more than one like
    if ($resultLikes->num_rows > 1) {
        echo ' and <b>' . ($resultLikes->num_rows - 1) . ' others</b>';
    }
    echo '</p>';
} else {
    echo 'No one has liked this post yet.';
}
echo '</div>';
$postId = $row['id'];
$sqlCommentCount = "SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = $postId";
$resultCommentCount = $conn->query($sqlCommentCount);
$commentCount = $resultCommentCount->fetch_assoc()['comment_count'];
        echo '        <div class="caption1">';
        echo '            <p><b>'  . '</b> ' . htmlspecialchars($row["description"]) . '</p>';
        echo '        </div>';
        echo '<div class="comments1 text-muted1" style="cursor: pointer;" onclick="toggleComments(' . $row["id"] . ')">View all ' . $commentCount . ' comments</div>';
                echo '    </div>';
        echo '</div>';
    }
} else {
    echo "No posts found for this user.";
}
} else {
echo "User not found.";
}
$conn->close();
?>


<script>
    // Get all share buttons
    const shareBtns = document.querySelectorAll('.interaction-button1 .uil.uil-share');
    
    // Loop through each share button
    shareBtns.forEach(shareBtn => {
        // Add click event listener to each share button
        shareBtn.addEventListener('click', () => {
            // Find the corresponding share options for this share button
            const shareOptions = shareBtn.closest('.action-button1').querySelector('.share-options');
            
            // Toggle the visibility of share options
            shareOptions.classList.toggle('active');
        });
    });
</script>
<script>
    function copyLink(postId) {
        // Select the link element
        var linkElement = document.getElementById('linkContainer_' + postId).querySelector('.link');
        
        // Create a temporary input element to copy the text
        var tempInput = document.createElement('input');
        tempInput.value = linkElement.textContent;
        document.body.appendChild(tempInput);
        
        // Select the text within the input element
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); /* For mobile devices */
        
        // Copy the text to the clipboard
        document.execCommand('copy');
        
        // Remove the temporary input element
        document.body.removeChild(tempInput);
        
        // Notify the user that the link has been copied
        alert('Link copied to clipboard!');
    }
</script>


</div>