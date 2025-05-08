

        <li class="has-child expand">
            <a href="#" class="icon-small">Reviews<span class="mini-text"></span></a>
            <div class="content">
                <div class="reviews">
                    <h4>Customers Reviews</h4>
                    <div class="review-block">
                        <div class="review-block-head">
                        <?php
                            include "../login/config.php";
                            
                            // Get the product ID from the URL parameter
                            $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                            
                            // Validate product ID
                            if ($product_id <= 0) {
                                echo 'Product ID is missing or invalid.';
                                exit();
                            }
                            
                            // Count the number of reviews for the product
                            $stmt = $conn->prepare("SELECT COUNT(*) AS review_count FROM productreviews WHERE product_id = ?");
                            $stmt->bind_param("i", $product_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $review_count = $row['review_count'];
                            $stmt->close();
                            
                            // Calculate the average star rating for the product
                            $stmt = $conn->prepare("SELECT AVG(stars) AS avg_rating FROM productreviews WHERE product_id = ?");
                            $stmt->bind_param("i", $product_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $avg_rating = $row['avg_rating'];
                            
                            // Format the average rating to one decimal place
                            $avg_rating = number_format($avg_rating, 1);
                            
                            $stmt->close();
                            $conn->close();
                            ?>

                                                                        
                            <div class="flexitem">
                                <span class="rate-sum"><?php echo $avg_rating; ?></span>
                                <span><?php echo $review_count; ?> Reviews</span>
                            </div>


                            <a href="#review-form" class="secondary-button">Write review</a>
                        </div>
                        <?php
                        include "../login/config.php";
                        
                        // Get the product ID from the URL parameter
                        $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                        
                        // Validate product ID
                        if ($product_id <= 0) {
                            echo 'Product ID is missing or invalid.';
                            exit();
                        }
                        
                        // Prepare the query to fetch reviews for the specified product ID
                        $stmt = $conn->prepare("SELECT name, date, stars, summary, review FROM productreviews WHERE product_id = ?");
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        // Fetch the reviews as an associative array
                        $reviews = [];
                        while ($row = $result->fetch_assoc()) {
                            $reviews[] = $row;
                        }
                        
                        $stmt->close();
                        $conn->close();
                        ?>


                <div class="review-block-body">
                    <ul>
                        <?php error_reporting(0); foreach ($reviews as $review): ?>
                            <li class="item">
                                <div class="review-form">
                                    <p class="person">Review by <?php echo $review['name']; ?></p>
                                    <p class="mini-text">On <?php echo $review['date']; ?></p>
                                </div>
                                <div class="review-rating rating">
                                    <?php
                                    // Convert star rating from number to icon
                                    $stars = intval($review['stars']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $stars) {
                                            echo '<i class="ri-star-fill"></i>';
                                        } else {
                                            echo '<i class="ri-star-line"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="review-title">
                                    <p><?php echo $review['summary']; ?></p>
                                </div>
                                <div class="review-text">
                                    <p><?php echo $review['review']; ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="second-links">
                    <a href="#" class="view-all">View all reviews <i class="ri-arrow-right-line"></i></a>
                </div>
            </div>
            <form id="review-submit-form" action="" method="post">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $id; ?>"> <!-- Product ID -->
            <input type="hidden" id="email" name="email" value="<?php echo $_SESSION['email']; ?>"> <!-- Session email -->
            <input type="hidden" id="date" name="date"> <!-- Hidden input for current date -->
            <input type="hidden" id="rating-value" name="rating" value="">
            <div id="review-rorm" class="review-form">
                <h4>Write a review</h4>
                <div class="rating">
                    <p>Are you satisfied enough?</p>
                    <div class="rate-this">
                        <input type="radio" name="star-rating" id="star5" value="5">
                        <label for="star5"><i class="ri-star-fill"></i></label>
        
                        <input type="radio" name="star-rating" id="star4" value="4">
                        <label for="star4"><i class="ri-star-fill"></i></label>
        
                        <input type="radio" name="star-rating" id="star3" value="3">
                        <label for="star3"><i class="ri-star-fill"></i></label>
        
                        <input type="radio" name="star-rating" id="star2" value="2">
                        <label for="star2"><i class="ri-star-fill"></i></label>
        
                        <input type="radio" name="star-rating" id="star1" value="1">
                        <label for="star1"><i class="ri-star-fill"></i></label>
                    </div>
                </div>
                    <p>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">
                    </p>
                    <p>
                        <label for="summary">Summary</label>
                        <input type="text" id="summary" name="summary">
                    </p>
                    <p>
                        <label for="review">Review</label>
                        <textarea id="review" name="review" cols="30" rows="10"></textarea>
                    </p>
                    <button type="submit" class="primary-button">Submit Review</button>
                </form>
            </div>
        </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('review-submit-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        
        // Collect form data
        var productId = document.getElementById('product_id').value;
        var name = document.getElementById('name').value;
        var summary = document.getElementById('summary').value;
        var review = document.getElementById('review').value;
        var date = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
        
        // Populate hidden input field with current date
        document.getElementById('date').value = date;
        
        // Prepare data for sending
        var formData = new FormData(this); // Automatically includes all form fields
        
        // Send data to server via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'sendreview.php', true); // Adjust URL as needed
        
        // Handle AJAX errors
        xhr.onerror = function() {
            console.error('Error sending review data to server.');
        };
        
        // Handle AJAX success
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Handle success
                console.log('Review submitted successfully!');
                // Optionally, you can clear the form fields here
                document.getElementById('name').value = '';
                document.getElementById('summary').value = '';
                document.getElementById('review').value = '';
            } else {
                // Handle non-200 HTTP status
                console.error('Error submitting review. Server responded with status:', xhr.status);
            }
        };
        
        // Send the request
        xhr.send(formData);
    });
});
    // JavaScript to update the hidden input field with the selected rating value
    document.addEventListener('DOMContentLoaded', function () {
        var ratingInputs = document.querySelectorAll('input[name="star-rating"]');
        var ratingHiddenInput = document.getElementById('rating-value');
        
        ratingInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                ratingHiddenInput.value = this.value;
            });
        });
    });

</script>
<script>
    // Get references to the plus and minus buttons and the quantity input field
    const minusButton = document.querySelector('.minus');
    const plusButton = document.querySelector('.plus');
    const quantityInput = document.getElementById('quantity');

    // Add event listener to the minus button
    minusButton.addEventListener('click', function() {
        // Ensure the quantity is greater than 1 before decrementing
        if (quantityInput.value > 1) {
            quantityInput.value--;
        }
    });

    // Add event listener to the plus button
    plusButton.addEventListener('click', function() {
        // Increment the quantity
        quantityInput.value++;
    });
</script>
<script>
        $(document).ready(function() {
            // Initialize Swiper for big image container
            var bigImageSwiper = new Swiper('.big-image .swiper-container', {
                // Swiper options...
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

            // Initialize Swiper for thumbnail container
            var thumbnailSwiper = new Swiper('.small-image .swiper-container', {
                // Swiper options...
            });
        });
    </script>
    <script>
    // Add event listener to heart icons
document.querySelectorAll('.icon-largen').forEach(function(icon) {
    console.log("Heart icon found!"); // Check if this message appears in the console
    
    icon.addEventListener('click', function(event) {
        console.log("Heart icon clicked!"); // Check if this message appears in the console
        
        event.preventDefault(); // Prevent the default behavior of anchor tag
        
        // Toggle heart state
        var currentState = this.getAttribute('data-heart-state');
        
        if (currentState === 'unfilled') {
            // If heart is currently unfilled, mark it as filled and send product ID to server to add to wishlist
            var productId = this.getAttribute('data-product-id');
            sendToServer(productId, 'add');
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-line');
            heartIcon.classList.add('ri-heart-fill');
            
            // Update data attribute
            this.setAttribute('data-heart-state', 'filled');
        } else {
            // If heart is currently filled, mark it as unfilled and send product ID to server to remove from wishlist
            var productId = this.getAttribute('data-product-id');
            sendToServer(productId, 'remove');
            
            // Update heart icon class
            var heartIcon = this.querySelector('i');
            heartIcon.classList.remove('ri-heart-fill');
            heartIcon.classList.add('ri-heart-line');
            
            // Update data attribute
            this.setAttribute('data-heart-state', 'unfilled');
        }

        // Store the state in local storage with the product ID
        var productId = this.getAttribute('data-product-id');
        localStorage.setItem('heartState_' + productId, currentState === 'unfilled' ? 'filled' : 'unfilled');
    });
});

// Function to send product ID to server
function sendToServer(productId, action) {
    console.log("Sending request to server for product ID: " + productId + ", action: " + action); // Check if this message appears in the console
    
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Configure it: GET-request for the URL
    xhr.open('GET', '../wishlist/addwish.php?productId=' + productId + '&action=' + action, true);
    
    // Send the request over the network
    xhr.send();
    
    console.log("Request sent to server!"); // Check if this message appears in the console
}

// Retrieve the heart state from local storage on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.icon-largen').forEach(function(icon) {
        // Retrieve the product ID associated with this heart icon
        var productId = icon.getAttribute('data-product-id');
        var storedState = localStorage.getItem('heartState_' + productId);
        if (storedState) {
            icon.setAttribute('data-heart-state', storedState);
            var heartIcon = icon.querySelector('i');
            if (storedState === 'filled') {
                heartIcon.classList.remove('ri-heart-line');
                heartIcon.classList.add('ri-heart-fill');
            } else {
                heartIcon.classList.remove('ri-heart-fill');
                heartIcon.classList.add('ri-heart-line');
            }
        }
    });
});
</script>