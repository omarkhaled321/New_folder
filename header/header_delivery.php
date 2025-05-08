<li class="iscart ishover">
    <a href="../delivery/delivery.php">
        <div class="icon-large"><i class="ri-truck-line"></i></div>
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['email'])) {
            // Get user's email
            $email = $_SESSION['email'];
            
            // Database connection details
            include "../login/config.php";
            
            // Prepare and execute SQL query to count rows in the pending table for the user's email
            $stmt = $conn->prepare("SELECT COUNT(*) AS total_rows FROM pending WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Fetch the total number of rows
                $row = $result->fetch_assoc();
                $total_rows = $row['total_rows'];
                
                // Output the total number of rows
                echo '<div class="fly-item"><span class="item-number">' . $total_rows . '</span></div>';
            } else {
                // If no rows found, output 0
                echo '<div class="fly-item"><span class="item-number">0</span></div>';
            }
            
            // Close statement and connection
            $stmt->close();
            $conn->close();
        } else {
            // If user is not logged in, output 0
            echo '<div class="fly-item"><span class="item-number">0</span></div>';
        }
        ?>
    </a>
    <!-- Hover Content -->
    <div class="mini-cart">
        <div class="content">
            <div class="cart-body">
                <ul class="products mini">
                    <!-- Include PHP code to fetch and display pending items for delivery -->
                    <?php include '../delivery/minidelivery.php'; ?>
                </ul>
            </div>
        </div>
    </div>
</li>