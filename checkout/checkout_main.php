

<main>
            
<div class="single-checkout">
    <div class="container">
        <div class="wrapper">
            <div class="checkout flexwrap">
                <div class="item left styled">
                    <h1>Shipping Address</h1>
                    <form id="form" action="./pending.php" enctype="multipart/form-data" method="post">
                        <p>
                            <label for="Email">Email Address <span></span></label>
                            <input type="email" name="email" id="email" autocomplete="off">
                        </p>
                        <p>
                            <label for="fname">First Name <span></span></label>
                            <input type="text" name="fname" id="fname">
                        </p>
                        <p>
                            <label for="lname">Last Name <span></span></label>
                            <input type="text" name="lname" id="lname">
                        </p>
                        <p>
                            <label for="address">Streer Address <span></span></label>
                            <input type="text"name="address" id="address">
                        </p>
                        <p>
                        <label for="country">Country</label>
                            <select name="country" id="countrySelect">
                                <option value="1">Select a Country</option>
                                <option value="Lebanon">Lebanon</option>
                            </select>
                        </p>
                        <p>
                        <label for="state">State/Province</label>
                            <select name="state" id="stateSelect">
                                <option value="">Select a region, state or prevince</option>
                            </select>
                        </p>
                        <p>
                        <label for="state">Town</label>
                            <select name="town" id="townSelect">
                                <option value="">Select a town</option>
                            </select>
                        </p>
                        <p>
                            <label for="postal">Zip/Postal Code <span></span></label>
                            <input type="number" name="postal" id="postal">
                        </p>
                        <p>
                            <label for="phone">Phone Number <span></span></label>
                            <input type="number" name="phone" id="phone">
                        </p>
                        <p>
                        <label for="payment">Payment Method</label>
                            <select name="payment" id="payment">
                                <option value="">Select Payment Method</option>
                                <option value="visa">Visa Card</option>
                                <option value="mastercard">Master Card</option>
                                <option value="wish">Wish or OMT</option>
                                <option value="cash">When Delivered</option>
                            </select>
                        </p>
                        <div id="visaDetails" style="display: none;">
                            <p>
                                <label for="visaCardName">Name </label>
                                <input type="text" name="visaCardName" id="visaCardName">
                            </p>
                            <p>
                                <label for="visaCardNumber">Card Number</label>
                                <input type="text" name="visaCardNumber" id="visaCardNumber">
                            </p>
                            <p>
                                <label for="visaCardDate">Expiry Date</label>
                                <input type="text" name="visaCardDate" id="visaCardDate">
                            </p>
                            <p>
                                <label for="visaCardCVV">CVV</label>
                                <input type="text" name="visaCardCVV" id="visaCardCVV">
                            </p>
                            <!-- Add more fields for Visa card details here -->
                        </div>
                        <div id="masterCardDetails" style="display: none;">
                            <p>
                                <label for="masterCardName">Name </label>
                                <input type="text" name="masterCardName" id="masterCardName">
                            </p>
                            <p>
                                <label for="masterCardNumber">Card Number</label>
                                <input type="text" name="masterCardNumber"  id="masterCardNumber">
                            </p>
                            <p>
                                <label for="masterCardDate">Expiry Date</label>
                                <input type="text" name="masterCardDate"  id="masterCardDate">
                            </p>
                            <p>
                                <label for="masterCardCVV">CVV</label>
                                <input type="text" name="masterCardCVV"  id="masterCardCVV">
                            </p>
                            <!-- Add more fields for Visa card details here -->
                        </div>
                        <div id="wishDetails" style="display: none;">
                            <p>
                                <label for="wishNumber">Send to this Number </label>
                                <span>+961 76/755 421</span>
                            </p>
                            <p>
                                <label for="wishImage">Upload The Receipt Image or Any Other Evidence</label>
                                <input type="file" name="image-wish" accept="image/*">
                            </p>
                        </div>
                        <div class="primary-checkout">
                        <button type="submit" id="placeOrderBtn" class="primary-button">Place Order</button>
                    </div>
                </div>
                <div class="item right">
                    <h2>Order Summary</h2>
                    <div class="summary-order is_sticky">
                        <div class="summary-totals">
                            <ul>
                                <li>
                                    <span>Subtotal</span>
                                    <span id="subtotal_td">$0.00</span>
                                </li>
                                <li>
                                    <span>Discount</span>
                                    <span id="discount_td">$0.00</span>
                                </li>
                                <li>
                                    <span>Shipping</span>
                                    <span id="shipping_td">$5.00</span>
                                </li>
                                <li>
                                    <span>Total</span>
                                    <span id="total_td"><strong>$0.00</strong></span>
                                </li>
                            </ul>
                        </div>
                        <ul class="products mini">
                            <li class="item">
                            <style>
                                    #cart-table th,
                                    #cart-table td {
                                        padding: 10px; /* Adjust as needed */
                                    }
                                </style>
                                
                                <table id="cart-table">
                                    <thead>
                                        <tr>
                                            <th>Order Nb</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Size</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
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
                                        $stmt = $conn->prepare("SELECT id, product_id, image, name, price, qty, size, sizenumber FROM cart WHERE email = ?");
                                        $stmt->bind_param("s", $email);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                
                                        // Check if there are any rows returned
                                        if ($result->num_rows > 0) {
                                            // Loop through each row and display data in table
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                // Display visible table data
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td><img src='../img/" . $row['image'] . "' alt='Product Image' style='max-width: 150px; max-height: 150px;'></td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>$" . $row['price'] . "</td>";
                                                echo "<td>" . $row['sizenumber'] . " - " . $row['size'] . "</td>"; // Display size information
                                                echo "<td>" . $row['qty'] . "</td>";
                                                $subtotal = $row['price'] * $row['qty']; // Calculate subtotal
                                                echo "<td>$" . $subtotal . "</td>";
                                                $total_subtotal += $subtotal; // Add subtotal to total subtotal
                                                echo "</tr>";   
                                                // Hidden input fields to send data with form submission
                                                echo "<input type='hidden' name='order_number[]' value='" . $row['id'] . "'>";
                                                echo "<input type='hidden' name='image[]' value='" . $row['image'] . "'>";
                                                echo "<input type='hidden' name='name[]' value='" . $row['name'] . "'>";
                                                echo "<input type='hidden' name='price[]' value='" . $row['price'] . "'>";
                                                echo "<input type='hidden' name='qty[]' value='" . $row['qty'] . "'>";
                                                echo "<input type='hidden' name='subtotal[]' value='" . $subtotal . "'>";
                                                echo "<input type='hidden' name='product_id[]' value='" . $row['product_id'] . "'>";
                                                echo "<input type='hidden' name='size[]' value='" . $row['sizenumber'] . " - " . $row['size'] . "'>";
                                        }
                                            
                                        } else {
                                            // If no rows found, display a message
                                            echo "<tr><td colspan='6'>No items in cart.</td></tr>";
                                        }
                                
                                        // Close statement and connection
                                        $stmt->close();
                                        $conn->close();
                                    } else {
                                        // If user is not logged in, display a message
                                        echo "<tr><td colspan='6'>Please log in to view your cart.</td></tr>";
                                    }
                                    ?>
                                </form>
                                </tbody>
                                
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
    // Define state/province options for each country
    const statesByCountry = {
        "Lebanon": ["Beirut", "Mount Lebanon", "North Lebanon", "South Lebanon", "Nabatieh", "Beqaa"]
    };

    // Define town options for each state/province
    const townsByState = {
    "Beirut": ["Achrafieh", "Hamra", "Downtown Beirut", "Ras Beirut", "Mazraa", "Zkak el-Blat", "Mar Mikhael", "Clemenceau", "Mousseitbeh", "Rmeil", "Saifi", "Ramlet el-Baida", "Raouche"],
    "Mount Lebanon": ["Jounieh", "Broummana", "Baabda", "Aley", "Keserwan", "Zahle", "Brummana", "Hazmiyeh", "Bikfaya", "Dawra", "Chouf", "Sin el-Fil", "Dbayeh"],
    "North Lebanon": ["Tripoli", "Bsharri", "Batroun", "Zgharta", "Koura", "Zawie", "Qalamoun", "Minieh-Danniyeh", "Akkar", "Mina", "Anfeh", "Qalamun"],
    "South Lebanon": ["Saida", "Tyre", "Jezzine", "Nabatieh", "Zahrani", "Zawtar el-Charkiyeh", "Khardali", "Majdel Anjar", "Tayr Felsay", "Qassmieh", "Sarafand", "Hula"],
    "Nabatieh": ["Nabatieh", "Jibchit", "Bint Jbeil", "Marjayoun", "Hasbaya", "Kfar Roumman", "Kfar Fila", "Bazouriyeh", "Tayr Filsey", "Yater", "Houmin el-Faouqa", "Ainata"],
    "Beqaa": ["Zahle", "Chtaura", "Baalbek", "Hermel", "Riyaq", "Qab Elias", "Taanayel", "Anjar", "Saadnayel", "Nabi Chit", "Jdita", "Rayak", "Majdal Anjar", "Ablah", "Machghara"]
};


    // Function to populate state/province dropdown based on selected country
    function populateStates(country) {
        const stateSelect = document.getElementById('stateSelect');
        // Clear existing options
        stateSelect.innerHTML = '<option value="">Select a region, state or province</option>';
        // Add options for selected country if it is Lebanon
        if (country === "Lebanon") {
            statesByCountry[country].forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            });
        }
        // Populate towns for the selected state/province
        populateTowns();
    }

    // Function to populate town dropdown based on selected state/province
    function populateTowns() {
        const stateSelect = document.getElementById('stateSelect');
        const townSelect = document.getElementById('townSelect');
        const selectedState = stateSelect.value;
        // Clear existing options
        townSelect.innerHTML = '<option value="">Select a town</option>';
        // Add options for selected state/province
        townsByState[selectedState].forEach(town => {
            const option = document.createElement('option');
            option.value = town;
            option.textContent = town;
            townSelect.appendChild(option);
        });
    }

    // Event listener for country dropdown change
    document.getElementById('countrySelect').addEventListener('change', function() {
        const selectedCountry = this.value;
        populateStates(selectedCountry);
    });

    // Event listener for state/province dropdown change
    document.getElementById('stateSelect').addEventListener('change', function() {
        populateTowns();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var paymentSelect = document.getElementById('payment');
        var visaDetails = document.getElementById('visaDetails');
        var masterCardDetails = document.getElementById('masterCardDetails');
        var wishDetails = document.getElementById('wishDetails');

        paymentSelect.addEventListener('change', function() {
            var selectedPayment = paymentSelect.value;

            // Hide all additional details divs initially
            visaDetails.style.display = 'none';
            masterCardDetails.style.display = 'none';
            wishDetails.style.display = 'none';

            // Show additional details div based on selected payment method
            if (selectedPayment === 'visa') {
                visaDetails.style.display = 'block';
            } else if (selectedPayment === 'mastercard') {
                masterCardDetails.style.display = 'block';
            } else if (selectedPayment === 'wish') {
                wishDetails.style.display = 'block';
            }
            // Add similar blocks for other payment methods if needed
        });
    });
</script>