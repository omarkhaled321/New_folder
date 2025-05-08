<?php
session_start();

// Include the database connection file
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the form data
    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
        exit;
    }

    // Sanitize and escape input data to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Prepare the SQL query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, fetch the row
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; // The hashed password stored in the DB

        // Verify the password using password_verify
        if (password_verify($password, $stored_password)) {
            // Login successful, start session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            // Redirect to the dashboard or home page
            header("Location: ../index/index.php");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
