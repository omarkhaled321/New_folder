<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    exit("User not logged in");
}
include '../login/config.php';

// Get the user's email address from the session
$email = $_SESSION['email'];

// Query to select products from the wishlist for the user
$query = "SELECT products.*, wishlist.id AS wishlist_id FROM products JOIN wishlist ON products.id = wishlist.product_id WHERE wishlist.email = '$email'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='item'>";
        echo "<div class='media'>";
        echo "<div class='thumbnail object-cover'>";
        echo "<a href='#'>";
        echo "<img src='../img/" . $row["image"] . "' alt=''>";
        echo "</a>";
        echo "</div>";
        echo "<div class='hoverable'>";
        echo "<ul>";
        // Output heart icon with data attributes for wishlist ID and initial heart state
        $heartState = ($row['wishlist_id']) ? 'filled' : 'unfilled';
        echo "<li class='heart-icon' data-wishlist-id='" . $row["wishlist_id"] . "' data-product-id='" . $row["id"] . "' data-heart-state='$heartState'><a href='#'><i class='ri-heart-" . ($row['wishlist_id'] ? 'fill' : 'line') . "'></i></a></li>";
        echo "<li><a href='#'><i class='ri-eye-line'></i></a></li>";
        echo "<li><a href='#'><i class='ri-shuffle-line'></i></a></li>";
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
    echo "No products found in the wishlist";
}

// Close the database connection
mysqli_close($conn);
?>
<script>
// Add event listener to heart icons
document.querySelectorAll('.heart-icon').forEach(function(icon) {
    icon.addEventListener('click', function() {
        // Toggle heart state
        var currentState = this.getAttribute('data-heart-state');
        
        if (currentState === 'unfilled') {
            // If heart is currently unfilled, mark it as filled and send product ID to server to add to wishlist
            var wishlistId = this.getAttribute('data-wishlist-id');
            var productId = this.getAttribute('data-product-id');
            sendToServer(wishlistId, productId, 'add');
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-line');
            heartIcon.classList.add('ri-heart-fill');
            
            // Update data attributes
            this.setAttribute('data-wishlist-id', 'wishlistId');
            this.setAttribute('data-heart-state', 'filled');
        } else {
            // If heart is currently filled, mark it as unfilled and send wishlist ID to server to remove from wishlist
            var wishlistId = this.getAttribute('data-wishlist-id');
            var productId = this.getAttribute('data-product-id');
            sendToServer(wishlistId, productId, 'remove');
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-fill');
            heartIcon.classList.add('ri-heart-line');
            
            // Update data attributes
            this.setAttribute('data-wishlist-id', '');
            this.setAttribute('data-heart-state', 'unfilled');
        }

        // Store the state in local storage with the product ID
        var productId = this.getAttribute('data-product-id');
        localStorage.setItem('heartState_' + productId, currentState === 'unfilled' ? 'filled' : 'unfilled');
    });
});

// Function to send wishlist ID and product ID to server
function sendToServer(wishlistId, productId, action) {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Configure it: GET-request for the URL
    xhr.open('GET', './addwish.php?wishlistId=' + wishlistId + '&productId=' + productId + '&action=' + action, true);
    
    // Send the request over the network
    xhr.send();
}

// Retrieve the heart state from local storage on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.heart-icon').forEach(function(icon) {
        // Retrieve the wishlist ID associated with this heart icon
        var wishlistId = icon.getAttribute('data-wishlist-id');
        if (wishlistId) {
            // Heart is filled
            icon.setAttribute('data-heart-state', 'filled');
            var heartIcon = icon.querySelector('i');
            heartIcon.classList.remove('ri-heart-line');
            heartIcon.classList.add('ri-heart-fill');
        } else {
            // Heart is unfilled
            icon.setAttribute('data-heart-state', 'unfilled');
            var heartIcon = icon.querySelector('i');
            heartIcon.classList.remove('ri-heart-fill');
            heartIcon.classList.add('ri-heart-line');
        }
    });
});
</script>
