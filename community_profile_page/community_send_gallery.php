<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    // Redirect the user to the login page or handle the authentication process
    header("Location: ../login/login.php");
    exit();
}

// Database connection
include "../login/config.php";

// Prepare SQL statement to retrieve username and profile picture based on email
$sql = "SELECT username, image FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["email"]);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($username, $profile_pic);
    $stmt->fetch();

    // Get form data
    $name = $username;
    $email = $_SESSION["email"];
    $title = $_POST["title"] ?? "";
    $description = $_POST["description"] ?? "";
    $file = $_FILES["image"]["name"] ?? "";

    if (!empty($name) && !empty($title) && !empty($description) && !empty($file)) {
        // Proceed with database insertion
        $time = date("Y-m-d H:i:s");

        // Check if file is an image or a video
        $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'mp4'])) {
            // Prepare SQL statement to insert data into database
            $sql = "INSERT INTO posts (name, email, image, title, description, time, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $image = $file;
            if ($file_ext == 'mp4') {
                $image = pathinfo($file, PATHINFO_FILENAME) . '.mp4';
            }
            $stmt->bind_param("sssssss", $name, $email, $image, $title, $description, $time, $profile_pic);

            // Execute the statement
            if ($stmt->execute()) {
                // Save the file to the server
                $target_dir = "communityimg/";
                $target_file = $target_dir . basename($image);
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Display alert using JavaScript
                    echo '<script>alert("Post submitted successfully."); setTimeout(function(){ window.location.href = "community.php"; }, 100);</script>';
                    exit();
                } else {
                    echo '<script>alert("Error: ' . $conn->error . '");</script>';
                }
            } else {
                echo '<script>alert("Error: ' . $conn->error . '");</script>';
            }
        } else {
            echo '<script>alert("Invalid file type. Please upload an image or a video.");</script>';
        }
    } else {
        echo '<script>alert("Please fill out all required fields.");</script>';
    }
} else {
    echo '<script>alert("User not found.");</script>';
}

// Close connection
$stmt->close();
$conn->close();
?>
