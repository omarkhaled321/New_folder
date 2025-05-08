<!-- menu bottom---------------------------------------------------------------------------------------------- -->
        <div class="menu-buttom desktop-hide">
            <div class="container">
                <div class="wrapper">
                    <nav>
                        <ul class="flexitem">
                            <li>
                                <a href="shop.php">
                                    <i class="ri-store-line"></i>
                                    <span>Shop</span>
                                </a>
                            </li>
                            <li>
                                <a href="settings.php">
                                    <i class="ri-user-6-line"></i>
                                    <span>Account</span>
                                </a>
                            </li>
                            <li>
                                <a href="./wishlist.php">
                                    <i class="ri-heart-line"></i>
                                    <span>Whishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="t-search">
                                    <i class="ri-search-line"></i>
                                    <span>Search</span>
                                </a>
                            </li>
                            <li>
                                <a href="./cart.php">
                                    <i class="ri-shopping-cart-line"></i>
                                    <span>Cart</span>
                                    <?php
                                    // Check if the user is logged in
                                    if (isset($_SESSION['email'])) {
                                        // Get user's email
                                        $email = $_SESSION['email'];
                                        include '../login/config.php';
                                    
                                        // Prepare and execute SQL query to count rows in the cart for the user
                                        $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM cart WHERE email = ?");
                                        $stmt->bind_param("s", $email);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                    
                                        // Check if there are any rows returned
                                        if ($result->num_rows > 0) {
                                            // Fetch the total number of items
                                            $row = $result->fetch_assoc();
                                            $total_items = $row['total_items'];
                                    
                                            // Output the total number of items
                                            echo '<div class="fly-item"><span class="item-number">' . $total_items . '</span></div>';
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
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


<!-- search buttom------------------------------------------------------------------------- -->
        <div class="search-buttom desktop-hide">
            <div class="container">
                <div class="wrapper">
                    <form id="searchForm1" action="searcheditems.php" method="GET" class="search">
                        <span class="icon-large"><i class="ri-search-line"></i></span>
                        <input id="searchInput1" type="search" name="query" placeholder="Search for products">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
<script>
    //show search
const searchButton = document.querySelector('.t-search'),
      tClose = document.querySelector('.search-close'),
      showClass = document.querySelector('.site');
searchButton.addEventListener('click', function(){
    showClass.classList.toggle('showsearch')
})
tClose.addEventListener('click', function(){
    showClass.classList.remove('showsearch')
})
</script>

<!-- overlay------------------------------------------------------------------------------------------------ -->
        <div class="overlay"></div>




    </div>