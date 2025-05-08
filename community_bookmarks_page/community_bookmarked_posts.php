<?php
session_start();

$postID = $_POST['post_id'];
$postName = $_POST['name'];
$postTime = $_POST['time'];
$postImage = $_POST['image'];
$profilePic = $_POST['profile_pic']; // Retrieve profile pic
$description = $_POST['description']; // Retrieve description

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if ($userEmail) {
    include "../login/config";

    $sqlCheck = "SELECT * FROM bookmarks WHERE post_id = '$postID' AND email = '$userEmail'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        $sqlDelete = "DELETE FROM bookmarks WHERE post_id = '$postID' AND email = '$userEmail'";
        if ($conn->query($sqlDelete) === TRUE) {
            echo "Bookmark deleted successfully.";
        } else {
            echo "Error deleting bookmark: " . $conn->error;
        }
    } else {
        $sqlInsert = "INSERT INTO bookmarks (post_id, email, name, time, image, profile_pic, description) VALUES ('$postID', '$userEmail', '$postName', '$postTime', '$postImage', '$profilePic', '$description')";
        if ($conn->query($sqlInsert) === TRUE) {
            echo "Bookmark saved successfully.";
        } else {
            echo "Error saving bookmark: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "User email not found in session.";
}
?>
