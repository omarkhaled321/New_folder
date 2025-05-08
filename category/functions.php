<?php

function fetchProducts($categories) {
include "../login/config.php";

    // Prepare an array to store IDs or names
    $categoryConditions = [];

    // Check if $categories is an array or a single value
    if (!is_array($categories)) {
        // If it's a single value (either ID or name), convert it to an array
        $categories = array($categories);
    }

    // Loop through each category and determine if it's an ID or name
    foreach ($categories as $category) {
        if (is_numeric($category)) {
            // If numeric, assume it's a category ID
            $categoryConditions[] = "c.id = " . intval($category);
        } else {
            // Otherwise, assume it's a category name
            $categoryConditions[] = "c.name = '" . mysqli_real_escape_string($conn, $category) . "'";
        }
    }

    // If at least one category condition is specified
    if (!empty($categoryConditions)) {
        // Join the conditions with OR for multiple categories
        $categoryCondition = implode(" OR ", $categoryConditions);

        // Build the query to join Products, ProductCategories, and Categories
        $query = "SELECT p.* FROM Products p 
                  INNER JOIN Product_categories pc ON p.id = pc.product_id 
                  INNER JOIN Categories c ON pc.category_id = c.id 
                  WHERE $categoryCondition";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            $products = array();
            while ($row = mysqli_fetch_assoc($result)) {
                // Add each product to the products array
                $products[] = $row;
            }
            // Close the database conn
            mysqli_close($conn);
            return $products;
        } else {
            mysqli_close($conn);
            return "No products found";
        }
    } else {
        mysqli_close($conn);
        return "Please select at least one category";
    }
}
?>
