<script>
function toggleComments(postId) {
    var commentsSection = document.getElementById('commentsSection_' + postId);
    if (commentsSection) {
        if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
            commentsSection.style.display = 'block';
        } else {
            commentsSection.style.display = 'none';
        }
    } else {
        console.error("Comments section not found for post ID: " + postId);
    }
}
</script>
<script>
    //get profile picture==============================================
document.addEventListener('DOMContentLoaded', () => {
    const userProfilePic = document.querySelector('#user-profile-pic img');

    fetch('community_profile_picture.php')
        .then(response => response.json())
        .then(data => {
            if (data.profilePictureUrl) {
                userProfilePic.src = data.profilePictureUrl;
            } else {
                console.error('Error fetching profile picture:', data.error);
            }
        })
        .catch(error => console.error('Error fetching profile picture:', error));
});
</script>
<script>
//add image in post================================================
document.getElementById('add-button2').addEventListener('click', function() {
  document.getElementById('product_image').click();
});

function previewImage(input) {
  var preview = document.getElementById('image-preview');
  var addButton = document.getElementById('add-button2');
  
  if (input.files && input.files[0]) {
    var file = input.files[0];
    var reader;
    
    if (file.type.startsWith('image/')) {
      reader = new FileReader();
      
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        addButton.style.display = 'none'; // Hide the add button
      }
      
      reader.readAsDataURL(file); // Convert image to base64 string
    } else if (file.type.startsWith('video/')) {
      var video = document.createElement('video');
      video.src = URL.createObjectURL(file);
      video.style.display = 'block';
      video.style.width = '100%';
      video.style.height = 'auto';
      video.controls = true;
      preview.parentNode.replaceChild(video, preview); // Replace the image preview with the video element
      addButton.style.display = 'none'; // Hide the add button
    }
  } else {
    preview.src = '#';
    preview.style.display = 'none';
    addButton.style.display = 'block'; // Show the add button if no image or video is selected
  }
}
</script>
<script>
    function showGallery(event) {
        event.preventDefault();
        var galleryForm = document.getElementById("galleryForm");
        var feelingForm = document.getElementById("feelingForm");

        // Hide other forms
        feelingForm.style.display = "none";

        if (galleryForm.style.display === "none") {
            galleryForm.style.display = "block";
        } else {
            galleryForm.style.display = "none";
        }
    }

    function showFeeling(event) {
        event.preventDefault();
        var galleryForm = document.getElementById("galleryForm");
        var feelingForm = document.getElementById("feelingForm");

        // Hide other forms
        galleryForm.style.display = "none";

        if (feelingForm.style.display === "none") {
            feelingForm.style.display = "block";
        } else {
            feelingForm.style.display = "none";
        }
    }
</script>

<script>
    var sessionUsername = "<?php echo htmlspecialchars($_SESSION['username']); ?>";
    var sessionProfilePic = "<?php echo htmlspecialchars($_SESSION['image']); ?>";
</script>

<script>
// Add event listener to heart icons
document.querySelectorAll('.heart-icon').forEach(function(icon) {
    icon.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of anchor tag
        
        // Toggle heart state
        var currentState = this.getAttribute('data-heart-state');
        var productId = this.getAttribute('data-product-id');
        
        if (currentState === 'unfilled') {
            // If heart is currently unfilled, mark it as filled and send product ID to server to add to wishlist
            sendToServer(productId, 'add', sessionUsername, sessionProfilePic);
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-line');
            heartIcon.classList.add('ri-heart-fill');
            
            // Update data attribute
            this.setAttribute('data-heart-state', 'filled');
        } else {
            // If heart is currently filled, mark it as unfilled and send product ID to server to remove from wishlist
            sendToServer(productId, 'remove', sessionUsername, sessionProfilePic);
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-fill');
            heartIcon.classList.add('ri-heart-line');
            
            // Update data attribute
            this.setAttribute('data-heart-state', 'unfilled');
        }

        // Store the state in local storage with the product ID and username
        localStorage.setItem('heartState_' + sessionUsername + '_' + productId, currentState === 'unfilled' ? 'filled' : 'unfilled');
    });
});

// Function to send product ID, username, and profile picture to server
function sendToServer(productId, action, username, profilePic) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure it: GET-request for the URL
    xhr.open('GET', 'community_liked_posts.php?productId=' + productId + '&action=' + action + '&username=' + encodeURIComponent(username) + '&profilePic=' + encodeURIComponent(profilePic), true);

    // Send the request over the network
    xhr.send();
}

// Retrieve the heart state from local storage on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.heart-icon').forEach(function(icon) {
        // Retrieve the product ID associated with this heart icon
        var productId = icon.getAttribute('data-product-id');
        var storedState = localStorage.getItem('heartState_' + sessionUsername + '_' + productId);
        if (storedState) {
            icon.setAttribute('data-heart-state', storedState);
            var heartIcon = icon.querySelector('i');
            if (storedState === 'filled') {
                heartIcon.classList.remove('ri-heart-line');
                heartIcon.classList.add('ri-heart-fill');
            } else {
                heartIcon.classList.remove('ri-heart-fill');
                heartIcon.classList.add('ri-heart-line');
            }
        }
    });
});


</script>

<script>
// Define loggedInUser globally
// Define loggedInUser globally
var loggedInUser = {
    id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>,
    username: '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>',
    image: '<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : ''; ?>'
};


// Assume this function is called when the user logs in or when the page loads
function initializeUser(user) {
    loggedInUser = user;
}

document.addEventListener('DOMContentLoaded', function() {
    var bookmarkIcons = document.querySelectorAll('.bookmark-icon');

    bookmarkIcons.forEach(function(bookmarkIcon) {
        var postID = bookmarkIcon.getAttribute('bookmark-product-id');

        var savedState = sessionStorage.getItem('user_' + getUserID() + '_bookmark_state_' + postID);
        if (savedState === 'filled') {
            var iconElement = bookmarkIcon.querySelector('i');
            iconElement.classList.remove('ri-bookmark-line');
            iconElement.classList.add('ri-bookmark-fill');
            bookmarkIcon.setAttribute('data-bookmark-state', 'filled');
        }

        bookmarkIcon.addEventListener('click', function(event) {
    event.preventDefault();

    var name = bookmarkIcon.getAttribute('data-name');
    var time = bookmarkIcon.getAttribute('data-post-time');
    var postImage = bookmarkIcon.getAttribute('data-post-image');
    var profilePic = bookmarkIcon.getAttribute('data-profile-pic'); // New line
    var description = bookmarkIcon.getAttribute('data-description'); // New line
    var bookmarkState = bookmarkIcon.getAttribute('data-bookmark-state');
    var userID = getUserID();

    var newState = (bookmarkState === 'filled') ? 'unfilled' : 'filled';
    var iconElement = bookmarkIcon.querySelector('i');
    if (newState === 'filled') {
        iconElement.classList.remove('ri-bookmark-line');
        iconElement.classList.add('ri-bookmark-fill');
    } else {
        iconElement.classList.remove('ri-bookmark-fill');
        iconElement.classList.add('ri-bookmark-line');
    }

    bookmarkIcon.setAttribute('data-bookmark-state', newState);

    sessionStorage.setItem('user_' + userID + '_bookmark_state_' + postID, newState);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'community_bookmarked_posts.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    // Modify data sent in the request
    xhr.send('user_id=' + userID + '&post_id=' + postID + '&name=' + name + '&time=' + time + '&image=' + postImage + '&profile_pic=' + profilePic + '&description=' + description);
});

    });
});

function getUserID() {
    if (loggedInUser && loggedInUser.id) {
        return loggedInUser.id;
    } else {
        console.error("User ID not found. Please make sure loggedInUser object is properly initialized.");
        return null;
    }
}
</script>
<script>
    document.getElementById('addStory').addEventListener('click', function() {
        // Toggle the visibility of the cards
        var createstory = document.getElementById('createstory');
        var addactivity = document.getElementById('addactivity');

        if (createstory.style.display === 'block') {
            createstory.style.display = 'none';
            addactivity.style.display = 'none';
        } else {
            createstory.style.display = 'block';
            addactivity.style.display = 'block';
        }
    });

    // Set initial state
    window.addEventListener('DOMContentLoaded', function() {
        var createstory = document.getElementById('createstory');
        var addactivity = document.getElementById('addactivity');

        // Check if any card is displayed
        if (createstory.style.display === 'block' || addactivity.style.display === 'block') {
            createstory.style.display = 'none';
            addactivity.style.display = 'none';
        }
    });
</script>
<style>
 .photo1 {
    min-width: 300px;
  }
 .photo1 video {
    max-height: 680px;
    object-fit: cover;
  }
  .form-control {
  border-radius: 20px;
  padding: 10px;
}

.btn1.btn-primary1 {
  border-radius: 20px;
  padding: 10px;
}
</style>
<?php
// Connect to your database
include "../login/config.php";

// Fetch data from the 'posts' table ordered by time in descending order
$sql = "SELECT * FROM posts ORDER BY time DESC";
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
        $profilePicPath = '../profileimg/' . $row['profile_pic']; // Adjust the path as necessary
        echo '                <img src="../profileimg/' . htmlspecialchars($profilePicPath) . '" alt="">';
        echo '            </div>';
        echo '            <div class="info1">';
        echo '                <h3>' . htmlspecialchars($row["name"]) . '</h3>';
        echo '                <small>' . htmlspecialchars($row["time"]) . '</small>';
        echo '            </div>';
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
        echo '    <p class="link">http://localhost/projects/New Folder/community/community.php?id=' . $row["id"] . '</p>'; // Link to the community page with post ID as parameter
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
                echo '        <img src="../img/' . htmlspecialchars($commenterProfilePicPath) . '" alt="">';
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
        echo '                <img src="../img/noprofile.jpg" alt="">';
        echo '            </div>';
        echo '            <textarea name="comment" class="form-control" placeholder="Enter your comment..."></textarea>'; // Add a textarea for the comment
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
    data-post-image="' . htmlspecialchars($row['image']) . '"
    data-description="' . htmlspecialchars($row['description']) . '">
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
