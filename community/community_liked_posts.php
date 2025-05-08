<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    exit("User not logged in");
}

// Get the user's email address from the session
$email = $_SESSION['email'];

// Connect to your database
include "../login/config.php";
// Retrieve user's last name from the database
$lastname = "";
$selectUserQuery = "SELECT lastname FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $selectUserQuery);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastname = $row['lastname'];
} else {
    // Handle case where user is not found in the signup table
    exit("User not found");
}

// Check if necessary parameters are provided
if (!isset($_GET['productId']) || !isset($_GET['action']) || !isset($_GET['username']) || !isset($_GET['profilePic'])) {
    exit("Missing parameters");
}

// Get the parameters from the request
$productId = $_GET['productId'];
$action = $_GET['action'];
$username = $_GET['username'];
$profilePic = $_GET['profilePic'];

// Retrieve the post owner's email from the database
$postOwnerEmailQuery = "SELECT email FROM posts WHERE id = $productId";
$postOwnerEmailResult = mysqli_query($conn, $postOwnerEmailQuery);
if (mysqli_num_rows($postOwnerEmailResult) > 0) {
    $postOwnerEmailRow = mysqli_fetch_assoc($postOwnerEmailResult);
    $postOwnerEmail = $postOwnerEmailRow['email'];
} else {
    exit("Post not found");
}

if ($action === 'add') {
    // Add to wishlist
    $insertQuery = "INSERT INTO likedposts (post_id, email, name, profile_pic) VALUES ($productId, '$email', '$username', '$profilePic')";
    if (mysqli_query($conn, $insertQuery)) {
        // Send notification
        $notificationContent = " $username $lastname liked your post."; // Including last name in notification
        $insertNotificationQuery = "INSERT INTO notifications (username, lastname, sender_email, receiver_email, content, time, profile_pic, status) VALUES ('$username', '$lastname', '$email', '$postOwnerEmail', '$notificationContent', NOW(), '$profilePic', 'unread')";
        mysqli_query($conn, $insertNotificationQuery);
        
        echo "Product added to wishlist successfully";
    } else {
        echo "Error adding product to wishlist: " . mysqli_error($conn);
    }
} elseif ($action === 'remove') {
    // Remove from wishlist
    $deleteQuery = "DELETE FROM likedposts WHERE post_id = $productId AND email = '$email'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Product removed from wishlist successfully";
    } else {
        echo "Error removing product from wishlist: " . mysqli_error($conn);
    }
} else {
    echo "Invalid action";
}

// Close the database conn
mysqli_close($conn);
?>