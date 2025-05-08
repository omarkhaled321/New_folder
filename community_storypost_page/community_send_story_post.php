<?php
session_start(); // Start session if not already started

// Database configuration
include "../login/config.php";

// Check if email session variable is set
if (isset($_SESSION['email'])) {
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
            $user_name = $row['username']; // Assuming 'username' is the column name in your table
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if post_content and photo are set and not empty
    if (isset($_POST['post_content']) && !empty($_POST['post_content'])) {
        // Sanitize input data
        $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);

        // Check if a file is uploaded
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file_name = $_FILES['photo']['name'];
            $file_tmp_name = $_FILES['photo']['tmp_name'];
            $file_size = $_FILES['photo']['size'];
            $file_type = $_FILES['photo']['type'];

            // Determine the file extension
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Define allowed file extensions for images and videos
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi');

            // Check if the file extension is allowed
            if (in_array($file_extension, $allowed_extensions)) {
                // Define the target directory
                $target_dir = "../uploads/";

                // Optional: create a unique name to avoid overwriting (recommended)
                $new_file_name = uniqid() . '_' . basename($file_name);

                $target_file = $target_dir . $new_file_name;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($file_tmp_name, $target_file)) {
                    // Insert post data into stories table, saving only the file name in DB
                    $insert_query = "INSERT INTO stories (name, profile_pic, title, photo, email) VALUES ('$user_name', '$image_url', '$post_content', '$new_file_name', '$user_email')";
                    if (mysqli_query($conn, $insert_query)) {
                        echo "Post inserted successfully.";
                    } else {
                        echo "Error inserting post: " . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, MOV, and AVI files are allowed.";
            }
        } else {
            echo "Please select a file to upload.";
        }
    } else {
        echo "Please fill out all required fields.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
