<div class="related-products"> 
    <div class="container">
        <div class="wrapper">
            <div class="column">
                <div class="sectop flexitem">
                    <h2><span class="circle"></span><span>Shop Now</span></h2>
                </div>
            </div>
            <style>
                .flexwrap {
                    display: flex;
                    flex-wrap: wrap;
                }
                .row.products.big {
                    display: flex;
                    justify-content: space-between;
                    width: 100%;
                }
                .item {
                    flex: 1;
                    margin: 10px;
                }
                .media img {
                    width: 100%;
                    height: auto;
                }
            </style>

            <div class="flexwrap">
                <div class="row products big">
                    <!-- First Product -->
                    <div class="item">
                        <?php
                        include '../login/config.php';
                        // Query to select product with id equal to 2
                        $query1 = "SELECT * FROM products WHERE id = 2";
                        
                        // Execute the query
                        $result1 = mysqli_query($conn, $query1);
                        
                        // Check if there is a row returned
                        if (mysqli_num_rows($result1) == 1) {
                            // Output data of the product
                            $row1 = mysqli_fetch_assoc($result1);
                            if (isset($row1)) {
                                if (isset($row1['price']) && isset($row1['oprice']) && isset($row1['discount']) && isset($row1['name']) && isset($row1['stock']) && isset($row1['sold'])) {
                                    echo '<div class="offer">
                                            <p>Offer ends at</p>
                                            <ul id="countdown1" class="flexcenter">
                                                <li id="days1">00</li>
                                                <li id="hours1">00</li>
                                                <li id="minutes1">00</li>
                                                <li id="seconds1">00</li>
                                            </ul>
                                        </div>';
                                    echo '<div class="media">
                                            <div class="image">
                                                <a href="../product_view/product_view.php?id='.$row1['id'].'&price='.$row1['price'].'&oprice='.$row1['oprice'].'&discount='.$row1['discount'].'&name='.urlencode($row1['name']).'&image='.urlencode($row1['image']).'">
                                                    <img src="../images_products/' .$row1['image'].'" alt="">
                                                </a>
                                            </div>
                                            <div class="discount circle flexcenter"><span>'.$row1['discount'].'</span></div>
                                        </div>';
                                    echo '<div class="content">
                                            <h3 class="main-links"><a href="#">'.$row1['name'].'</a></h3>
                                            <div class="price">
                                                <span class="current">$'.$row1['price'].'</span>
                                                <span class="normal mini-text">$'.$row1['oprice'].'</span>
                                            </div>
                                            <div class="stock mini-text">
                                                <div class="qty">
                                                    <span>Stock: <strong class="qty-available">'.$row1['stock'].'</strong></span>
                                                    <span>Sold: <strong class="qty-sold">'.$row1['sold'].'</strong></span>
                                                </div>
                                                <div class="bar">
                                                    <div class="available" style="width: '.($row1['stock'] / ($row1['stock'] + $row1['sold']) * 100).'%;"></div>
                                                </div>
                                            </div>
                                        </div>';
                                } else {
                                    echo "Product data is incomplete.";
                                }
                            } else {
                                echo "No data retrieved for the product.";
                            }
                        } else {
                            echo "Product with ID 2 not found";
                        }
                        ?>
                    </div>
                    <!-- Second Product -->
                    <div class="item">
                        <?php
                        // Query to select product with id equal to 3
                        $query2 = "SELECT * FROM products WHERE id = 3";
                        
                        // Execute the query
                        $result2 = mysqli_query($conn, $query2);
                        
                        // Check if there is a row returned
                        if (mysqli_num_rows($result2) == 1) {
                            // Output data of the product
                            $row2 = mysqli_fetch_assoc($result2);
                            if (isset($row2)) {
                                if (isset($row2['price']) && isset($row2['oprice']) && isset($row2['discount']) && isset($row2['name']) && isset($row2['stock']) && isset($row2['sold'])) {
                                    echo '<div class="offer">
                                            <p>Offer ends at</p>
                                            <ul id="countdown2" class="flexcenter">
                                                <li id="days2">00</li>
                                                <li id="hours2">00</li>
                                                <li id="minutes2">00</li>
                                                <li id="seconds2">00</li>
                                            </ul>
                                        </div>';
                                    echo '<div class="media">
                                            <div class="image">
                                                <a href="../product_view/product_view.php?id='.$row2['id'].'&price='.$row2['price'].'&oprice='.$row2['oprice'].'&discount='.$row2['discount'].'&name='.urlencode($row2['name']).'&image='.urlencode($row2['image']).'">
                                                    <img src="./../images_products/'.$row2['image'].'" alt="">
                                                </a>
                                            </div>
                                            <div class="discount circle flexcenter"><span>'.$row2['discount'].'</span></div>
                                        </div>';
                                    echo '<div class="content">
                                            <h3 class="main-links"><a href="#">'.$row2['name'].'</a></h3>
                                            <div class="price">
                                                <span class="current">$'.$row2['price'].'</span>
                                                <span class="normal mini-text">$'.$row2['oprice'].'</span>
                                            </div>
                                            <div class="stock mini-text">
                                                <div class="qty">
                                                    <span>Stock: <strong class="qty-available">'.$row2['stock'].'</strong></span>
                                                    <span>Sold: <strong class="qty-sold">'.$row2['sold'].'</strong></span>
                                                </div>
                                                <div class="bar">
                                                    <div class="available" style="width: '.($row2['stock'] / ($row2['stock'] + $row2['sold']) * 100).'%;"></div>
                                                </div>
                                            </div>
                                        </div>';
                                } else {
                                    echo "Product data is incomplete.";
                                }
                            } else {
                                echo "No data retrieved for the product.";
                            }
                        } else {
                            echo "Product with ID 3 not found";
                        }
                        
                        // Close the database connection
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>

<script>
// Reusable countdown function
function startCountdown(endDate, countdownId, daysId, hoursId, minutesId, secondsId) {
    const countdownDate = new Date(endDate).getTime();

    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById(daysId).innerText = days < 10 ? "0" + days : days;
        document.getElementById(hoursId).innerText = hours < 10 ? "0" + hours : hours;
        document.getElementById(minutesId).innerText = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById(secondsId).innerText = seconds < 10 ? "0" + seconds : seconds;

        if (distance < 0) {
            clearInterval(countdown);
            document.getElementById(countdownId).innerHTML = "<li>00</li><li>00</li><li>00</li><li>00</li>";
        }
    }, 1000);
}

// Start countdowns for both products
startCountdown("July 30, 2024 23:59:59", "countdown1", "days1", "hours1", "minutes1", "seconds1");
startCountdown("July 30, 2024 23:59:59", "countdown2", "days2", "hours2", "minutes2", "seconds2");
</script>


            <div class="products main flexwrap">
                <?php include '../product_select/product_select_1.php'; ?>
            </div>
        </div>
    </div>
</div>