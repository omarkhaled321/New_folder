<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get input
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if password is set
    if (isset($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        // Handle the error appropriately
        echo "<script>alert('Password is required.');</script>";
        exit;
    }

    $defaultImage = "noprofil.jpg";

    // Check if email already exists
    $checkEmail = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Show alert for email already exists
        echo "<script>alert('This email is already registered. Please use another one.');</script>";
        echo "<script>window.location.href='login.php';</script>"; // Redirect to signup page
    } else {
        // Insert into DB
        $sql = "INSERT INTO users (username, email, password, image)
                VALUES ('$user', '$email', '$pass', '$defaultImage')";

        if ($conn->query($sql) === TRUE) {
            // Show success alert after successful registration
            echo "<script>alert('Registration successful! Please login.');</script>";
            echo "<script>window.location.href='../index/index.php';</script>"; // Redirect to login page
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>