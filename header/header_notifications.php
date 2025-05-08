
<li class="iscart ishover">
    <a href="../main_notifications/main_notifications.php">
        <div class="icon-large"><i class="ri-notification-line"></i></div>
        <?php
        include('../login/config.php');

        // Check if the user is logged in
        if (isset($_SESSION['email'])) {
            // Get user's email
            $email = $_SESSION['email'];

            // Prepare and execute SQL query to count unread notifications for the user
            $stmt = $conn->prepare("SELECT COUNT(*) AS total_unread FROM main_notifications WHERE reciever_email = ? AND is_read = 0");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are any rows returned
            if ($result->num_rows > 0) {
                // Fetch the total number of unread notifications
                $row = $result->fetch_assoc();
                $total_unread = $row['total_unread'];

                // Output the total number of unread notifications
                echo '<div class="fly-item"><span class="item-number">' . $total_unread . '</span></div>';
            } else {
                // If no unread notifications found, output 0
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
                    <?php include '../main_notifications/mininotifications.php'; ?>
                </ul>
            </div>
        </div>
    </div>
</li>
                </ul>
            </div>
        </div>
    </div>
</div>