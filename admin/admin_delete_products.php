<?php
include "../login/config.php"; // Include your database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID from the URL and ensure it's an integer

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the slider page with a success message
        header("Location: ./admin_add_products_page.php?message=Slider deleted successfully");
    } else {
        // Handle error
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    // Handle case where no ID is provided
    echo "No ID provided for deletion.";
}

$conn->close();
?>