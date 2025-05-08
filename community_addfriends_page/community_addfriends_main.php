
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

// Fetch all users from the 'signup' table excluding the current user
$sqlUsers = "SELECT username, lastname, image, email FROM users WHERE email != '$currentUserEmail'";
$resultUsers = $conn->query($sqlUsers);

// Fetch all friends of the current user
$sqlFriends = "SELECT friend_email FROM friends WHERE user_email = '$currentUserEmail'";
$resultFriends = $conn->query($sqlFriends);

$friends = [];
if ($resultFriends->num_rows > 0) {
    $friends = $resultFriends->fetch_all(MYSQLI_ASSOC);
}

$users = [];
if ($resultUsers->num_rows > 0) {
    $users = $resultUsers->fetch_all(MYSQLI_ASSOC);
}

// Close the connection
$conn->close();
?>

<div class="middle1">
    <div class="story-section">
        <div class="friend-requests1">
            <h4>Add Friends</h4>
            <?php foreach ($users as $user): ?>
                <?php
                $isFriend = false;
                foreach ($friends as $friend) {
                    if ($friend['friend_email'] == $user['email']) {
                        $isFriend = true;
                        break;
                    }
                }
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
                                <p class="text-muted1">8 mutual friends</p>
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
    </div>

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


</div>
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
</div>