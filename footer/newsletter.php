<?php
// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get the email from the form
    $email = $_POST['email'];
    
    // Validate email (optional)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email
        echo "Invalid email address";
        exit;
    }
    
    // Connect to your database
    include "../config.php";

    // Prepare and execute SQL query to insert email into the newsletter table
    $query = "INSERT INTO newsletter (email) VALUES ('$email')";
    if (mysqli_query($connection, $query)) {
        // Close the database connection
        mysqli_close($connection);
        
        // Display temporary message
        echo "<p>Thank you for subscribing!</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000); // 2000 milliseconds = 2 seconds
              </script>";
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
} else {
    // Redirect user back to the form if the form is not submitted
    header("Location: ./index.php");
    exit;
}
?>
