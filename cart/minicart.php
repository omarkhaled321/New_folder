<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or display a message
    echo "<p>Please <a href='login.php'>login</a> to view your cart.</p>";
} else {
    // User is logged in, proceed with displaying cart content

    // Connect to your database
    include "../login/config.php";

    // Get the user's email address from the session
    $email = $_SESSION['email'];

    // Query to select products from the cart for the user
    $query = "SELECT products.*, cart.qty FROM products JOIN cart ON products.id = cart.product_id WHERE cart.email = '$email'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Initialize subtotal variable
        $subTotal = 0;

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
            echo "<li><a href='#'><i class='ri-eye-line'></i></a></li>";
            echo "<li><a href='#'><i class='ri-shuffle-line'></i></a></li>";
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            echo "<div class='content'>";
            echo "<h3 class='main-links'><a href='#'>" . $row["name"] . "</a></h3>";
            echo "<div class='price'>";
            echo "<span class='current'>$" . $row["price"] . "</span>";
            echo "</div>";
            echo "<div class='stock mini-text' data-stock='" . $row["stock"] . "'>";
            echo "<div class='qty'>";
            echo "<span>Qty: <strong class='qty-sold'>" . $row["qty"] . "</strong></span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            // Calculate subtotal
            $subTotal += $row['price'] * $row['qty']; // Assuming 'price' is the column name in the database
        }

        // Output the subtotal within the cart-footer section
        echo "<div class='cart-footer'>";
        echo "<div class='subtotal'>";
        echo "<p>Subtotal</p>";
        echo "<p><strong>$" . $subTotal . "</strong></p>";
        echo "</div>";
        echo "<div class='actions'>";
        echo "<a href='../checkout/checkout.php' class='primary-button'>Proceed to Checkout</a>";
        echo "<a href='../wishlist/wishlist.php' class='secondary-button'>View Wishlist</a>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "Your cart is empty";
    }

    // Close the database conn
    mysqli_close($conn);
}
?>
