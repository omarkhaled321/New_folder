
<div class="middle1">
<div class="stories-slider">
<?php
// Database connection details
include "../login/config.php";

// Ensure the user is logged in and their email is set in the session
if (!isset($_SESSION['email'])) {
    echo '<p>Please log in</p>';
    exit; // Stop further execution
}

$email = $_SESSION['email'];

// Fetch the user's profile picture and name from the database
$sql = "SELECT image, username FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image, $username);
    mysqli_stmt_fetch($stmt);

    if ($image && $username) {
        $profilePictureUrl = '../profileimg/' . htmlspecialchars($image);
        $userName = htmlspecialchars($username);
    } else {
        $profilePictureUrl = '../img/noprofile.jpg';
        $userName = 'User';
    }

    mysqli_stmt_close($stmt);
} else {
    die('Query failed: ' . mysqli_error($conn));
}

mysqli_close($conn);
?>

                    
                <form class="create-post1">
                    <div class="profile-pic1">
                    <a href="community_profile_page.php"> <!-- Change 'profile.php' to the desired page -->
                        <img src="<?php echo $profilePictureUrl; ?>" alt="User Profile Picture">
                    </a>
                    </div>
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

<style>
 .photo1 {
    min-width: 300px;
  }
 .photo1 video {
    max-height: 680px;
    object-fit: cover;
  }
</style>
<?php
// Connect to your database
include "../login/config.php";
// Assuming you have stored user's email in session variable 'user_email'
$userEmail = $_SESSION['email']; // Adjust as per your session variable name

// Fetch data from the 'bookmarks' table for the logged-in user
$sql = "SELECT * FROM bookmarks WHERE email = '$userEmail' ORDER BY time DESC";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="feeds1">';
        echo '    <div class="feed1">';
        echo '        <div class="head1">';
        echo '            <!-- Head content, if any -->';
        echo '        </div>';
        echo '        <div class="user1">';
        echo '            <div class="profile-pic1">';
        // Fetch the user's profile picture URL from the database and display it
        $profilePicPath = '../profileimg/' . $row['image']; // Adjust the path as necessary
        echo '                <img src="../profileimg/' . htmlspecialchars($profilePicPath) . '" alt="">';
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
        $imagePath = '../profileimg/'. $row['image'];
        $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
        
        if ($ext == 'mp4' || $ext == 'webm' || $ext == 'ogg') {
            // Display video
            echo '    <div class="photo1">';
            echo '        <video width="100%" controls>';
            echo '            <source src="'. htmlspecialchars($imagePath). '" type="video/'. $ext. '">';
            echo '            Your browser does not support the video tag.';
            echo '        </video>';
            echo '    </div>';
        } else {
            // Display image
            echo '    <div class="photo1">';
            echo '        <img class="feed-image" src="'. htmlspecialchars($imagePath). '" alt="">';
            echo '    </div>';
        }
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
        $stmtComments->bind_param('i', $row['post_id']);
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
        echo "            <input type='hidden' name='post_id' value='" . $row['post_id'] . "'>"; // Passing post_id to the form
        echo "            <input type='hidden' name='name' value='" . htmlspecialchars($sessionUsername) . "'>"; // Passing name to the form
        echo "            <input type='hidden' name='profile_pic' value='" . htmlspecialchars($sessionProfilePic) . "'>"; // Passing profile_pic to the form        
        echo '            <div class="profile-pic3">';
        echo '                <img src="img/profile-8.jpg" alt="">';
        echo '            </div>';
        echo "            <input type='hidden' name='post_id' value='" . $row['post_id'] . "'>"; // Passing post_id to the form
        echo '            <input type="submit" value="Post" class="btn1 btn-primary1">';
        echo '        </form>';
        
        echo '    </div>';
        echo '</div>';
        

// Assuming this PHP block is within a loop fetching rows
echo '<div class="bookmark1">';
echo '<span class="bookmark-icon" 
    bookmark-product-id="' . $row["post_id"] . '" 
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
$postId = $row['post_id'];

// Query to fetch users who liked the post
$sqlLikes = "SELECT * FROM likedposts WHERE post_id = $postId";
$resultLikes = $conn->query($sqlLikes);

echo '<div class="liked-by1">';
if ($resultLikes && $resultLikes->num_rows > 0) {
    // Displaying users who liked the post
    while ($like = $resultLikes->fetch_assoc()) {
        $profilePicPath = '../profileimg/' . $like['profile_pic']; // Adjust the path as necessary

        echo '<span><img src="../img/' . htmlspecialchars($profilePicPath) . '" alt=""></span>';
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
$postId = $row['post_id'];
$sqlCommentCount = "SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = $postId";
$resultCommentCount = $conn->query($sqlCommentCount);
$commentCount = $resultCommentCount->fetch_assoc()['comment_count'];
        echo '        <div class="caption1">';
        echo '            <p><b>'  . '</b> ' . htmlspecialchars($row["description"]) . '</p>';
        echo '        </div>';
        echo '<div class="comments1 text-muted1" style="cursor: pointer;" onclick="toggleComments(' . $row["post_id"] . ')">View all ' . $commentCount . ' comments</div>';
                echo '    </div>';
        echo '</div>';
    }
} else {
    echo "0 results";
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