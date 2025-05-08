<?php
// Check if the product ID is provided
if (isset($_POST['id'])) {
    // Get the product ID from the request
    $productId = $_POST['id'];

    // Connect to the database
    include "../login/config.php";

    // Prepare and execute SQL query to delete the row from the cart table
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send a response back to the client if needed
    echo "Item removed from cart successfully.";
} else {
    // If product ID is not provided, send an error response
    echo "Product ID is missing.";
}
?>
