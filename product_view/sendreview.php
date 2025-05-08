<?php
include "../login/config.php";

// Retrieve form data
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$name = $_POST['name'];
$summary = $_POST['summary'];
$review = $_POST['review'];
$email = $_POST['email'];
$date = $_POST['date']; // Note: Change this to match the name of your date field
$stars = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

if ($product_id <= 0 || empty($name) || empty($email) || empty($stars)) {
    echo 'Please fill in all required fields.';
    exit();
}

try {
    // Prepare the query to insert the review into the database
    $stmt = $conn->prepare("INSERT INTO productreviews (product_id, name, summary, review, email, date, stars) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $product_id, $name, $summary, $review, $email, $date, $stars); // Bind parameters

    // Execute the query
    $stmt->execute();
    
    // Respond to the client
    echo 'Review submitted successfully!';
} catch (mysqli_sql_exception $e) {
    // Log error
    error_log('Error inserting review into database: ' . $e->getMessage());
    // Respond to the client with an error message
    echo 'Error submitting review. Please try again later.';
}

$stmt->close();
$conn->close();
?>
