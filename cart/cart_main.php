<div class="single-cart">
<div class="container">
    <div class="wrapper">
    <div class="breadcrumb">
        <ul class="flexitem">
        </ul>
    </div>
        <div class="page-title">
            <h1>Shopping Cart</h1>
        </div>
        <div class="products one cart">
            <div class="flexwrap">
                <form action="" class="form-cart">
                    <div class="item">
                        <table id="cart-table">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>qty</th>
                                    <th>Size</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_subtotal = 0; // Initialize total subtotal
                            
                            // Check if the user is logged in
                            if (isset($_SESSION['email'])) {
                                // Get user's email
                                $email = $_SESSION['email'];
                                include "../login/config.php";
                                // Prepare and execute SQL query to fetch cart items for the user
                                $stmt = $conn->prepare("SELECT id, image, name, price, qty, sizenumber, size FROM cart WHERE email = ?");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            
                                // Check if there are any rows returned
                                if ($result->num_rows > 0) {
                                    // Loop through each row and display data in table
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td><img src='../img/" . $row['image'] . "' alt='Product Image' style='max-width: 150px; max-height: 150px;'></td>"; // Specify maximum width and height
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>$" . $row['price'] . "</td>";
                                        echo "<td>" . $row['qty'] . "</td>";
                                        echo "<td>" . $row['sizenumber'] . " - " . $row['size'] . "</td>"; // Display size information
                                        echo "<td>$" . ($row['price'] * $row['qty']) . "</td>";
                                        $total_subtotal += $row['price'] * $row['qty']; // Add subtotal to total subtotal
                                        // Add any additional columns if needed
                                        echo "<td><button class='primary-button remove-btn' data-product-id='" . $row['id'] . "'>Remove</button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // If no rows found, display a message
                                    echo "<tr><td colspan='8'>No items in cart.</td></tr>";
                                }
                            
                                // Close statement and connection
                                $stmt->close();
                                $conn->close();
                            } else {
                                // If user is not logged in, display a message
                                echo "<tr><td colspan='8'>Please log in to view your cart.</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <div class="cart-summary styled">
                    <div class="item">
                        <div class="coupon">
                            <input type="text" placeholder="Enter coupon">
                            <button>Apply</button>
                        </div>
                        <div class="cart-total">
                            <table>
                                <tbody>
                                    <tr>
                                        <th >Subtotal</th>
                                        <td id="subtotal_td">$0.00</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td id="discount_td">$0.00</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td id="shipping_td">$5.00</td>
                                    </tr>
                                    <tr class="grand-total">
                                        <th>TOTAL</th>
                                        <td id="total_td"><strong>$0.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="../checkout/checkout.php" class="secondary-button">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Get reference to subtotal element
    var subtotalElement = document.getElementById("subtotal_td");
    var discountElement = document.getElementById("discount_td");
    var shippingElement = document.getElementById("shipping_td");
    var totalElement = document.getElementById("total_td");

    // Extract numerical values from subtotal element
    var subtotal = parseFloat(subtotalElement.textContent.trim().replace("$", "").replace(",", ""));

    // Wait for the page to load completely
    document.addEventListener("DOMContentLoaded", function() {
        // Extract numerical values from discount and shipping elements
        var discount = parseFloat(discountElement.textContent.trim().replace("$", "").replace(",", ""));
        var shipping = parseFloat(shippingElement.textContent.trim().replace("$", "").replace(",", ""));

        // Calculate total
        var total = subtotal + shipping - discount;

        // Update total element with the calculated total
        totalElement.innerHTML = "<strong>$" + total.toFixed(2) + "</strong>";
    });
</script>
<script>
    // Output the total subtotal directly into the Subtotal row
    document.getElementById('subtotal_td').innerText = '$<?php echo number_format($total_subtotal, 2); ?>';
</script>

<script>
    // Add event listener to update shipping information when the radio button changes
    document.getElementById('shipping-form').addEventListener('change', function() {
        var shippingRate = document.querySelector('input[name="rate-option"]:checked').nextElementSibling.textContent;
        document.getElementById('shipping-td').innerText = shippingRate;
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all remove buttons
    var removeButtons = document.querySelectorAll(".remove-btn");

    // Attach click event listener to each remove button
    removeButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Get the product ID from the data attribute
            var productId = this.getAttribute("data-product-id");

            // Send an AJAX request to the PHP script
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./removefromcart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page after successful removal
                    location.reload();
                }
            };
            xhr.send("id=" + productId);
        });
    });
});
</script>
