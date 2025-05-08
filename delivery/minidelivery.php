<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or display a message
    echo "<p>Please <a href='login.php'>login</a> to view your delivery details.</p>";
} else {
    // User is logged in, proceed with displaying delivery details

    // Connect to your database
    include "../login/config.php";

    // Get the user's email address from the session
    $email = $_SESSION['email'];

    // Query to select pending items for the user
    $query = "SELECT * FROM pending WHERE email = '$email'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Initialize total cost variable
        $totalCost = 0;

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='item'>";
            echo "<div class='media'>";
            echo "<div class='thumbnail object-cover'>";
            echo "<a href='#'>";
            echo "<img src='../img/" . $row["image"] . "' alt=''>";
            echo "</a>";
            echo "</div>";
            echo "</div>";
            echo "<div class='content'>";
            echo "<h3 class='main-links'><a href='#'>" . $row["name"] . "</a></h3>";
            echo "<div class='price'>";
            echo "<span class='current'>$" . $row["price"] . "</span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            // Calculate total cost
            $totalCost += $row['price']; // Assuming 'price' is the column name in the database
        }
        // Output the total cost within the cart-footer section
        echo "<div class='cart-footer'>";
        echo "<div class='total-cost'>";
        echo "<p>Total Cost</p>";
        echo "<p><strong>$" . $totalCost . "</strong></p>";
        echo "</div>";
        echo "<div class='actions'>";
        echo "<a href='./delivery.php' class='primary-button'>Proceed to Delivery</a>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No pending items found for delivery";
    }

    // Close the database conn
    mysqli_close($conn);
}
?>
