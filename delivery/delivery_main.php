
<div class="single-cart">
    <div class="container">
        <div class="wrapper">
        <div class="breadcrumb">
            <ul class="flexitem">
            </ul>
        </div>
            <div class="page-title">
                <h1>Pending Orders</h1>
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
                                        <th>Size</th>
                                        <th>Size Number</th>
                                        <th>qty</th>
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
                                        $stmt = $conn->prepare("SELECT order_number, image, name, price, size, sizenumber, qty, added_time FROM pending WHERE email = ?");
                                        $stmt->bind_param("s", $email);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        // Check if there are any rows returned
                                        if ($result->num_rows > 0) {
                                            // Loop through each row and display data in table
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['order_number'] . "</td>";
                                                echo "<td><img src='../img/" . $row['image'] . "' alt='Product Image' style='max-width: 150px; max-height: 150px;'></td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>$" . $row['price'] . "</td>";
                                                echo "<td>" . $row['size'] . "</td>";
                                                echo "<td>" . $row['sizenumber'] . "</td>";
                                                echo "<td>" . $row['qty'] . "</td>";
                                                $subtotal = $row['price'] * $row['qty']; // Calculate subtotal
                                                echo "<td>$" . $subtotal . "</td>";
                                                
                                                // Calculate time difference in seconds
                                                $added_time = strtotime($row['added_time']);
                                                $current_time = time();
                                                $time_difference = $current_time - $added_time;
                                            
                                                // Check if within the first 24 hours
                                                if ($time_difference <= 24 * 60 * 60) { // 24 hours in seconds
                                                    echo "<td><button class='primary-button remove-btn' data-product-id='" . $row['order_number'] . "'>Refund</button></td>";
                                                } else {
                                                    echo "<td>Refund period expired</td>";
                                                }
                                            
                                                echo "</tr>";
                                            }
                                            
                                        } else {
                                            // If no rows found, display a message
                                            echo "<tr><td colspan='7'>No items pending.</td></tr>";
                                        }
                                        
                                        // Close statement and connection
                                        $stmt->close();
                                        $conn->close();

                                    } else {
                                        // If user is not logged in, display a message
                                        echo "<tr><td colspan='7'>Please log in to view your cart.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="cart-summary styled" style="max-width: 300px; margin: 0 auto;">
                        <div class="item">
                            </div>
                            <div class="cart-total">
                                <p>Items are refundable within the first 24 hours of purchase.</p>
                                <a href="../shop/shop.php" class="secondary-button">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
document.querySelectorAll('.remove-btn').forEach(button => {
button.addEventListener('click', function() {
    var orderNumber = this.getAttribute('data-product-id');
    var row = this.closest('tr');

    // Send AJAX request to refund.php
    fetch('./refunded.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ order_number: orderNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the row from the table
            row.remove();
            alert('Item has been refunded successfully.');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the refund.');
    });
});
});
});
</script>