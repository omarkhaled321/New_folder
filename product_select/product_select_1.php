<?php
include '../login/config.php';
// Array of product IDs you want to retrieve
$product_ids = array(1, 2, 3); // Example IDs

// Convert the array of IDs to a comma-separated string for the query
$product_ids_str = implode(',', $product_ids);

// Query to select specific products from the database based on their IDs and user's country
$query = "SELECT * FROM products WHERE id IN ($product_ids_str)";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='item'>";
        echo "<div class='media'>";
        echo "<div class='thumbnail object-cover'>";
        echo "<a href='../product_view/product_view.php?id=" . $row["id"] . "&price=" . $row["price"] . "&oprice=" . $row["oprice"] . "&discount=" . $row["discount"] . "&name=" . urlencode($row["name"]) . "&image=" . urlencode($row["image"]) . "'>";
        echo "<img src='../images_products/" . $row["image"] . "' alt=''>";
        echo "</a>";
        echo "</div>";
        echo "<div class='hoverable'>";
        echo "<ul>";
        // Add onclick event to heart icon to toggle color
        // Add data attribute to indicate source
        echo "<li class='heart-icon product-selected' data-product-id='" . $row["id"] . "'><a href='#'><i class='ri-heart-line'></i></a></li>";
        echo "<li><a href='../product_view/product_view.php?id=" . $row["id"] . "&price=" . $row["price"] . "&oprice=" . $row["oprice"] . "&discount=" . $row["discount"] . "&name=" . urlencode($row["name"]) . "&image=" . urlencode($row["image"]) . "'><i class='ri-eye-line'></i></a></li>";
        echo "<li><a href='#'><i class='ri-camera-line'></i></a></li>";
        echo "</ul>";
        echo "</div>";
        echo "<div class='discount circle flexcenter'><span>" . $row["discount"] . "</span></div>";
        echo "</div>";
        echo "<div class='content'>";
        echo "<div class='rating'>";
        // Output rating stars based on the product's rating
        echo "</div>";
        echo "<h3 class='main-links'><a href='#'>" . $row["name"] . "</a></h3>";
        echo "<div class='price'>";
        echo "<span class='current'>$" . $row["price"] . "</span>";
        echo "<span class='normal mini-text'>$" . $row["oprice"] . "</span>";
        echo "</div>";
        // Output stock data
        echo "<div class='stock mini-text' data-stock='" . $row["stock"] . "'>";
        echo "<div class='qty'>";
        echo "<span>Sold: <strong class='qty-sold'>" . $row["sold"] . "</strong></span>";
        echo "<span>Stock: <strong class='qty-available'>" . $row["stock"] . "</strong></span>";
        echo "</div>";
        echo "<div class='bar'>";
        echo "<div class='available' style='width: " . (($row["sold"] / $row["stock"]) * 100) . "%'></div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found";
}

// Close the database connection
mysqli_close($conn);
?>
