<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration file
    include "../login/config.php";

    // Retrieve data from the form
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $profile_pic = isset($_POST['profile_pic']) ? $_POST['profile_pic'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $time = date("Y-m-d H:i:s");
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';

    // Check if DB connection exists
    if ($conn) {
        // Retrieve post owner's email based on post_id
        $sql_post = "SELECT email FROM posts WHERE id = ?";
        $stmt_post = mysqli_prepare($conn, $sql_post);
        mysqli_stmt_bind_param($stmt_post, "i", $post_id);
        mysqli_stmt_execute($stmt_post);
        $result_post = mysqli_stmt_get_result($stmt_post);

        if ($result_post && mysqli_num_rows($result_post) > 0) {
            $post_owner = mysqli_fetch_assoc($result_post);
            $receiver_email = $post_owner['email'];
        } else {
            // Handle case where post owner is not found
            echo "Post owner not found";
            exit();
        }

        // Retrieve the lastname of the user from the signup table
        $sql_user = "SELECT lastname FROM users WHERE email = ?";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "s", $email);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);

        if ($result_user && mysqli_num_rows($result_user) > 0) {
            $user = mysqli_fetch_assoc($result_user);
            $lastname = $user['lastname'];
        } else {
            // Handle case where user is not found in signup table
            echo "User not found in users table";
            exit();
        }

        // Insert data into comments table
        $sql_comments = "INSERT INTO comments (name, email, profile_pic, comment, time, post_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_comments = mysqli_prepare($conn, $sql_comments);
        mysqli_stmt_bind_param($stmt_comments, "sssssi", $name, $email, $profile_pic, $comment, $time, $post_id);
        $execute_comments = mysqli_stmt_execute($stmt_comments);

        if (!$execute_comments) {
            echo "Error inserting comment: " . mysqli_error($conn);
            exit();
        }

        // Insert data into notifications table
        $notification_content = "$name $lastname commented on your post";
        $status = "unread";
        $sql_notifications = "INSERT INTO notifications (username, lastname, sender_email, receiver_email, content, time, profile_pic, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_notifications = mysqli_prepare($conn, $sql_notifications);
        mysqli_stmt_bind_param($stmt_notifications, "ssssssss", $name, $lastname, $email, $receiver_email, $notification_content, $time, $profile_pic, $status);
        $execute_notifications = mysqli_stmt_execute($stmt_notifications);

        if (!$execute_notifications) {
            echo "Error inserting notification: " . mysqli_error($conn);
            exit();
        }

        // Optionally, redirect back to the previous page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    } else {
        echo "Database connection error.";
    }
} else {
    // Redirect to an error page if someone tries to access this script directly without submitting the form
    header("Location: error.php");
    exit();
}
?>
