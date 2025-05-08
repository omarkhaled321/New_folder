<div class="header-top mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <ul class="flexitem main-links">
                                <li><a href="../shop/shop.php"> <i class="ri-store-line"></i>shop</a></li>
                                <li><a href="../wishlist/wishlist.php"><i class="ri-heart-line"></i>Wishlist</a></li>
                                <li><a href="../cart/cart.php"><i class="ri-shopping-cart-line"></i>cart</a></li>
                                <li><a href="../category/category.php"><i class="ri-shirt-line"></i>Category</a></li>
                                <li><a href="../delivery/delivery.php"><i class="ri-truck-line"></i>Orders</a></li>

                            </ul>
                        </div>
                        <div class="right">
                            <ul class="flexitem main-links">
                            <?php
                                include "../login/config.php";
                                if(isset($_SESSION['email'])) {
                                    $email = $_SESSION['email'];
                                        
                                    // Prepare and execute SQL query
                                    $sql = "SELECT username FROM users WHERE email='$email'";
                                    $result = mysqli_query($conn, $sql);
                    
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output data of each row
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $username = $row["username"];
                                            echo "<h3>Welcome, $username</h3>";
                                        }
                                    } else {
                                        echo '<h3><a class="login-link" href="../login/login.php">LOGIN/SIGNUP</a></h3>';
                                    }
                                } else {
                                    echo '<h3><a class="login-link" href="../login/login.php">LOGIN/SIGNUP</a></h3>';
                                }
                                ?>
                    
                                <li><a href="../settings/settings.php" style="font-size: larger;">My Account</a></li>
                                <li class="dropdown">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>