<?php
session_start();

include "../login/config.php";

// Check if the product already exists in the wishlist for the user
$query = "SELECT * FROM wishlist WHERE product_id = $productId AND email = '$email'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    // Product already in wishlist, remove it
    $deleteQuery = "DELETE FROM wishlist WHERE product_id = $productId AND email = '$email'";
    if (mysqli_query($connection, $deleteQuery)) {
        echo "Product removed from wishlist successfully";
    } else {
        echo "Error removing product from wishlist: " . mysqli_error($connection);
    }
} else {
    // Product not in wishlist, add it
    $insertQuery = "INSERT INTO wishlist (product_id, email) VALUES ($productId, '$email')";
    if (mysqli_query($connection, $insertQuery)) {
        echo "Product added to wishlist successfully";
    } else {
        echo "Error adding product to wishlist: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>
