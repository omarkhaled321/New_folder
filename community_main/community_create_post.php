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
        $profilePictureUrl = '../img/noprofile.jpg';
        $userName = 'User';
    }
} else {
    die('Query failed: ' . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>
<form class="create-post1">
    <div class="profile-pic1" style="margin-right: 20px;">
    <a href="community_profile_page.php"> <!-- Change 'profile.php' to the desired page -->
        <img src="<?php echo $profilePictureUrl; ?>" alt="User Profile Picture">
    </a>
    </div>
    <label class="btn1 btn-primary1" for="create-post" style="margin-right: auto;">Create</label>
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