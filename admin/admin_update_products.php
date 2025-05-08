<?php
include "../login/config.php"; // Include your database configuration

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the product ID from the form
    $product_id = $_POST['product_id'];
    
    // Get the other product details from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $oprice = mysqli_real_escape_string($conn, $_POST['oprice']);
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $shipping = mysqli_real_escape_string($conn, $_POST['shipping']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $sold = mysqli_real_escape_string($conn, $_POST['sold']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);

    // Update the product in the database
    $query = "UPDATE products SET 
                name='$name', 
                price='$price', 
                oprice='$oprice', 
                discount='$discount', 
                shipping='$shipping', 
                stock='$stock', 
                sold='$sold', 
                category='$category', 
                brand='$brand' 
              WHERE id='$product_id'";

    if (mysqli_query($conn, $query)) {
        // Redirect back to the products page with a success message
        header("Location: admin_add_products_page.php?message=Product updated successfully");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: admin_add_products_page.php?error=Error updating product: " . mysqli_error($conn));
        exit();
    }
} else {
    // If the request method is not POST, redirect back to the products page
    header("Location: admin_add_products_page.php");
    exit();
}
?>