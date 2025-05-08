<?php

// Database configuration
include "../login/config.php";

// Check if email session variable is set
if(isset($_SESSION['email'])) {
    // Get the email from the session
    $user_email = $_SESSION['email'];

    // Query to fetch the image URL and name based on the user's email
    $query = "SELECT image, username FROM users WHERE email = '$user_email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_url = $row['image'];
            $user_name = $row['username']; // Assuming 'name' is the column name in your table
        } else {
            // No rows found for the user's email
            $image_url = null;
            $user_name = 'Unknown User';
        }
    } else {
        // Query execution failed
        $image_url = null;
        $user_name = 'Unknown User';
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Email session variable not set
    $image_url = null;
    $user_name = 'Unknown User';
}

// Close the database conn
mysqli_close($conn);
?>

<div class="middle1">
    <div class="story-section">
        <div class="container4">
            <div class="wrapper">
                <section class="post1">
                    <header>Create Post</header>
                    <form action="#" enctype="multipart/form-data" method="post" id="postForm">
                        <div class="content1">
                            <img src="../profileimg/<?php echo $image_url; ?>" alt="logo">
                            <div class="details">
                                <p><?php echo $user_name; ?></p>
                            </div>
                        </div>
                        <textarea name="post_content" placeholder="What's on your mind, <?php echo $user_name; ?>?" spellcheck="false" required></textarea>
                        <div class="options">
                            <p>Add to Your Post</p>
                            <ul class="list">
                                <li><img src="../img/gallery.svg" alt="gallery" id="imageIcon"></li>
                            </ul>
                        </div>
                        <input type="file" name="photo" id="imageInput" accept="image/*,video/*" style="display:none;">
                        <button type="submit">Post</button>
                    </form>
                    <button class="remove-button" id="removeImage" style="display:none;">&times;</button> <!-- X button for removing image -->
                    <video id="selectedVideo" controls style="display:none;"></video> <!-- Video element to display selected video -->
                    <img id="selectedImage" style="display:none;">
                </section>
            </div>
        </div>

        <script>
    // Image and video upload functionality
    document.getElementById('imageIcon').addEventListener('click', function() {
        document.getElementById('imageInput').click();
    });

    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const selectedImage = document.getElementById('selectedImage');
                const selectedVideo = document.getElementById('selectedVideo');
                if (file.type.startsWith('image')) {
                    selectedImage.src = e.target.result;
                    selectedImage.style.display = 'block';
                } else if (file.type.startsWith('video')) {
                    selectedVideo.src = e.target.result;
                    selectedVideo.style.display = 'block';
                }
                document.getElementById('removeImage').style.display = 'inline'; // Show remove button
            };
            reader.readAsDataURL(file);
        }
    });

    // X button functionality for removing the selected image or video
    document.getElementById('removeImage').addEventListener('click', function() {
        const selectedImage = document.getElementById('selectedImage');
        const selectedVideo = document.getElementById('selectedVideo');
        if (selectedImage.style.display !== 'none') {
            selectedImage.style.display = 'none';
        }
        if (selectedVideo.style.display !== 'none') {
            selectedVideo.style.display = 'none';
        }
        // Also clear the input file value if needed
        document.getElementById('imageInput').value = '';
        this.style.display = 'none'; // Hide the remove button
    });

    // Form submission using AJAX
    document.getElementById('postForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    const formData = new FormData(this); // Create FormData object to send form data

    // Append session email to FormData object
    formData.append('session_email', '<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>');

    // Make AJAX request
    fetch('community_send_story_post.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Log response from server

            // Redirect to another page after success
            // Change 'community.php' to your target page
            window.location.href = '../community/community.php';
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors
            // Optionally, you can display an error message to the user
        });
});

</script>
</div>
<?php
// Database connection details
include "../login/config.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure the user is logged in and their email is set in the session
if (!isset($_SESSION['email'])) {
    echo '<p>Please log in</p>';
    exit; // Stop further execution
}

$email = $_SESSION['email'];

// Prepare and execute the query to fetch the user's profile picture and name
$sql = "SELECT image, username FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image, $username);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!empty($image) && !empty($username)) {
        $profilePictureUrl = '../profileimg/' . htmlspecialchars($image);
        $userName = htmlspecialchars($username);
    } else {
        $profilePictureUrl = 'img/noprofil.jpg';
        $userName = 'User';
    }
} else {
    die('Query failed: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

</div>
            
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