<div class="header-main mobile-hide">
    <div class="container">
        <div class="wrapper flexitem">
            <div class="left">
                <div class="dpt-cat">
                    <div class="dpt-head">
                        <div class="main-text">All Departments</div>
                        <?php
                        include '../login/config.php';                              
                    // Query to get the total number of rows in the "products" table
                    $sql = "SELECT COUNT(*) AS total_products FROM products";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $totalProducts = $row["total_products"];
                    } else {
                        $totalProducts = 0;
                    }
                    // Close the database connection
                    $conn->close();
                    ?>
                    
                    <!-- Display the total number of products -->
                    <div class="mini-text mobile-hide">Total <?php echo $totalProducts; ?> Products</div>
                        <a href="#" class="dpt-trigger mobile-hide">
                            <i class="ri-menu-3-line ri-xl"></i>
                        </a>
                    </div>
                    <div class="dpt-menu">
                        <ul class="second-links">
                            <li class="has-child beauty">
                                <a href="#">
                                    <div class="icon-large"><i class="ri-bear-smile-line"></i></div>
                                    Beauty
                                    <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul>
                                    <li><a href="./category.php?category=makeup">Makeup</a></li>
                                    <li><a href="./category.php?category=skincare">Skin Care</a></li>
                                    <li><a href="./category.php?category=haircare">Hair Care</a></li>
                                    <li><a href="#">Fragrance</a></li>
                                    <li><a href="#">Foot & Hand Care</a></li>
                                    <li><a href="#">Tools & Accessories</a></li>
                                    <li><a href="#">Shave & Hair Removal</a></li>
                                    <li><a href="#">Personal Care</a></li>
                                </ul>
                            </li>
                            <li class="has-child electric">
                                <a href="#">
                                    <div class="icon-large"><i class="ri-bluetooth-connect-line"></i></div>
                                    Electronics
                                    <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul>
                                    <li><a href="#">Camera</a></li>
                                    <li><a href="#">Cell Phones</a></li>
                                    <li><a href="#">Computers</a></li>
                                    <li><a href="#">GPS & Navigation</a></li>
                                    <li><a href="#">Headphones</a></li>
                                    <li><a href="#">Home Audio</a></li>
                                    <li><a href="#">Television</a></li>
                                    <li><a href="#">Video Projectors</a></li>
                                    <li><a href="#">Wearable Technology</a></li>
                                </ul>
                            </li>
                            <li class="has-child fashion">
                                <a href="#">
                                    <div class="icon-large"><i class="ri-bear-smile-line"></i></div>
                                    Women's Fashion
                                    <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul>
                                    <li><a href="#">Clothing</a></li>
                                    <li><a href="#">Shoes</a></li>
                                    <li><a href="#">Jewelry</a></li>
                                    <li><a href="#">Watches</a></li>
                                    <li><a href="#">Handbags</a></li>
                                    <li><a href="#">Accessories</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-shirt-line"></i></div>
                                    Mens's Fashion
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-user-5-line"></i></div>
                                    Girl's's Fashion
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-user-6-line"></i></div>
                                    Boy's Fashion
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-heart-pulse-line"></i></div>
                                    Health & Household
                                </a>
                            </li>
                            <li class="has-child homekit">
                                <a href="#">
                                    <div class="icon-large"><i class="ri-home-8-line"></i></div>
                                    Home & Kitchen
                                    <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <div class="mega">
                                    <div class="flexcol">
                                        <div class="row">
                                            <h4><a href="#">Kitchen & Dining</a></h4>
                                            <ul>
                                                <li><a href="#">Kitchen</a></li>
                                                <li><a href="#">Dining Room</a></li>
                                                <li><a href="#">Pantry</a></li>
                                                <li><a href="#">Great Room</a></li>
                                                <li><a href="#">Breakfast Nook</a></li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <h4><a href="#">Living</a></h4>
                                            <ul>
                                                <li><a href="#">Living Room</a></li>
                                                <li><a href="#">Family Room</a></li>
                                                <li><a href="#">Sun Room</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="flexcol">
                                        <div class="row">
                                            <h4><a href="#">Bed & Bath</a></h4>
                                            <ul>
                                                <li><a href="#">Bathrooms</a></li>
                                                <li><a href="#">Powder Room</a></li>
                                                <li><a href="#">Bedroom</a></li>
                                                <li><a href="#">Storages & Closet</a></li>
                                                <li><a href="#">Baby & Kids</a></li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <h4><a href="#">Utility</a></h4>
                                            <ul>
                                                <li><a href="#">Laundry</a></li>
                                                <li><a href="#">Garage</a></li>
                                                <li><a href="#">Mudroom</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="flexcol">
                                        <div class="row">
                                            <h4><a href="#">Outdoor</a></h4>
                                            <ul>
                                                <li><a href="#">Landscape</a></li>
                                                <li><a href="#">Patio</a></li>
                                                <li><a href="#">Deck</a></li>
                                                <li><a href="#">Pool</a></li>
                                                <li><a href="#">Backyard</a></li>
                                                <li><a href="#">Porch</a></li>
                                                <li><a href="#">Exterior</a></li>
                                                <li><a href="#">Outdoor Kitchen</a></li>
                                                <li><a href="#">Front Yard</a></li>
                                                <li><a href="#">Driveway</a></li>
                                                <li><a href="#">Poolhouse</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-android-line"></i></div>
                                    Pet Supplies
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-basketball-line"></i></div>
                                    Sports
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="icon-large"><i class="ri-shield-star-line"></i></div>
                                    Best Seller
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="search-box">
                    <form id="searchForm" action="searcheditems.php" method="GET" class="search">
                        <span class="icon-large"><i class="ri-search-line"></i></span>
                        <input id="searchInput" type="search" name="query" placeholder="Search for products">
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    //show dpt menu
    const dptButton = document.querySelector('.dpt-cat .dpt-trigger'),
          dptClass = document.querySelector('.site');
    dptButton.addEventListener('click', function(){
        dptClass.classList.toggle('showdpt')
    })
</script>