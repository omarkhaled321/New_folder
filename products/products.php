<?php
// Connect to your database
$connection = mysqli_connect("localhost", "root", "", "1");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select products from the database
$query = "SELECT * FROM products";

// Execute the query
$result = mysqli_query($connection, $query);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
// Output data of each row
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='item'>";
    // Fetch logo path from the 'stores' table
    $storeQuery = "SELECT logo FROM stores WHERE storename = '" . $row["storename"] . "'";
    $storeResult = mysqli_query($connection, $storeQuery);
    if (mysqli_num_rows($storeResult) > 0) {
        $storeRow = mysqli_fetch_assoc($storeResult);
        $logoPath = "../uploads/" . $storeRow["logo"]; // Adjust path to include "uploads" folder
        
        // Output the logo and store name within an anchor tag
        echo "<a href='./storesview.php?storename=" . urlencode($row["storename"]) . "&logo=" . urlencode($logoPath) . "' class='store-link'>";
        echo "<div class='store-logo-container'>";
        echo "<div class='circle1 store-logo' style='background-image: url(" . $logoPath . ")'></div>"; // Add 'store-logo' class
        echo "<div class='store-name'>" . $row["storename"] . "</div>";
        echo "</div>";
        echo "</a>";
    }
    echo "<div class='media'>";
    // The rest of your code continues...

        echo "<div class='thumbnail object-cover'>";
        echo "<a href='../product_view/product_view.php?id=" . $row["id"] . "&price=" . $row["price"] . "&oprice=" . $row["oprice"] . "&discount=" . $row["discount"] . "&name=" . urlencode($row["name"]) . "&image=" . urlencode($row["image"]) . "'>";
        echo "<img src='../" . $row["image"] . "' alt=''>";
        echo "</a>";
        echo "</div>";
        echo "<div class='hoverable'>";
        echo "<ul>";
        // Add onclick event to heart icon to toggle color
        echo "<li class='heart-icon' data-product-id='" . $row["id"] . "' data-heart-state='unfilled'><a href='#'><i class='ri-heart-line'></i></a></li>";
        echo "<li><a href='../product_view/product_view.php?id=" . $row["id"] . "&price=" . $row["price"] . "&oprice=" . $row["oprice"] . "&discount=" . $row["discount"] . "&name=" . urlencode($row["name"]) . "&image=" . urlencode($row["image"]) . "'><i class='ri-eye-line'></i></a></li>";
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
    echo "No products found";
}

// Close the database connection
mysqli_close($connection);
?>

<script>
    // Add event listener to heart icons
    document.querySelectorAll('.heart-icon').forEach(function(icon) {
        icon.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of anchor tag
            
            // Toggle heart state
            var currentState = this.getAttribute('data-heart-state');
            
            if (currentState === 'unfilled') {
                // If heart is currently unfilled, mark it as filled and send product ID to server to add to wishlist
                var productId = this.getAttribute('data-product-id');
                sendToServer(productId, 'add');
                
                // Update heart icon class
                var heartIcon = this.querySelector('i');
                heartIcon.classList.remove('ri-heart-line');
                heartIcon.classList.add('ri-heart-fill');
                
                // Update data attribute
                this.setAttribute('data-heart-state', 'filled');
            } else {
                // If heart is currently filled, mark it as unfilled and send product ID to server to remove from wishlist
                var productId = this.getAttribute('data-product-id');
                sendToServer(productId, 'remove');
                
                // Update heart icon class
                var heartIcon = this.querySelector('i');
                heartIcon.classList.remove('ri-heart-fill');
                heartIcon.classList.add('ri-heart-line');
                
                // Update data attribute
                this.setAttribute('data-heart-state', 'unfilled');
            }

            // Store the state in local storage with the product ID
            var productId = this.getAttribute('data-product-id');
            localStorage.setItem('heartState_' + productId, currentState === 'unfilled' ? 'filled' : 'unfilled');
        });
    });

    // Function to send product ID to server
    function sendToServer(productId, action) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();
        
        // Configure it: GET-request for the URL
        xhr.open('GET', './addwish.php?productId=' + productId + '&action=' + action, true);
        
        // Send the request over the network
        xhr.send();
    }

    // Retrieve the heart state from local storage on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.heart-icon').forEach(function(icon) {
            // Retrieve the product ID associated with this heart icon
            var productId = icon.getAttribute('data-product-id');
            var storedState = localStorage.getItem('heartState_' + productId);
            if (storedState) {
                icon.setAttribute('data-heart-state', storedState);
                var heartIcon = icon.querySelector('i');
                if (storedState === 'filled') {
                    heartIcon.classList.remove('ri-heart-line');
                    heartIcon.classList.add('ri-heart-fill');
                } else {
                    heartIcon.classList.remove('ri-heart-fill');
                    heartIcon.classList.add('ri-heart-line');
                }
            }
        });
    });
</script>
<style>
.store-logo-container {
    display: flex; /* Use flexbox for layout */
    align-items: center; /* Center items vertically */
}

.circle1 {
    width: 100px;
    height: 100px;
    border: 2px solid blue;
    border-radius: 50%;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    max-width: 50px;
    max-height: 50px;
}

.store-name {
    margin-left: 10px; /* Adjust margin as needed */
    font-weight: bold; /* Example: Make the store name bold */
}


.circle1 img {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover; /* Ensures the entire image is visible within the circle */
}


</style>