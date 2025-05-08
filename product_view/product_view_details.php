<div class="row">
    <div class="item">
        <h1><?php echo $name; ?></h1>
        <div class="content">
            <div class="rating">
            </div>
            <div class="price">
                <span class="current">$<?php echo $price; ?></span>
                <span class="normal">$<?php echo $oprice; ?></span>
            </div>
        </div>
        <div class="sizes">
            <p>Size</p>
            <div class="variant">
                <form action="">
                <?php
                include '../login/config.php';
                // Get product ID from URL parameters
                $product_id = isset($_GET['id']) ? $_GET['id'] : '';
                
                if (!empty($product_id)) {
                    // Prepare and execute MySQLi statement
                    $stmt = $conn->prepare("SELECT size FROM products WHERE id = ?");
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $stmt->bind_result($sizes_string);
                    $stmt->fetch();
                    $stmt->close();
                
                    if (!empty($sizes_string)) {
                        $sizes = explode('; ', $sizes_string); // Split sizes by semicolon and space
                
                        foreach ($sizes as $size) {
                            $size = trim($size);
                            if (!empty($size)) {
                                $size_id = 'size-' . strtolower($size);
                                ?>
                                <p>
                                <input type="radio" name="size_radio" id="<?php echo $size_id;?>" value="<?php echo $size;?>" onclick="document.getElementById('selected_size').value = this.value;">
                                <label for="<?php echo $size_id; ?>" class="circle"><span><?php echo $size; ?></span></label>
                                </p>
                                <?php
                            }
                        }
                    } else {
                        echo "No sizes found for product ID: $product_id";
                    }
                } else {
                    echo "Product ID is missing or invalid.";
                }
                
                // Close MySQLi connection
                $conn->close();
                ?>

                </form>
            </div>
        </div>
        <div class="actions">
            <form method="post" action="../cart/addtocart.php">
            <div class="qty-control flexitem">
                <button type="button" class="minus circle">-</button>
                <input type="text" value="1" name="quantity" id="quantity">
                <button type="button" class="plus circle">+</button>
            </div>
            
            <!-- Form for adding to cart -->
            <form method="post" action="./addtocart.php" id="addToCartForm">
                <!-- Hidden input fields for other product data -->
                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="image" value="<?php echo $image; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <input type="hidden" name="selected_size" id="selected_size" value="">
                <input type="hidden" name="selected_sizenumber" id="selected_sizenumber" value="">
                <!-- Submit button for the form -->
                <button type="submit" class="primary-button">Add to Cart</button>
            </form>
            </div>
                <script>
                function updateSelectedSize(size, sizenumber) {
                    document.getElementById('selected_size').value = size;
                    document.getElementById('selected_sizenumber').value = sizenumber;
                }
                </script>
                <div class="wish-share">
                    <ul class="flexitem second-links">
                    <li><a href="#">
                    <span class='icon-largen' data-product-id='<?php echo $id; ?>'><i class='ri-heart-line'></i></span>
                    <span>Wishlist</span>
                        </a></li>
                        <li><a href="#" id="share-btn">
                            <span class="icon-large"><i class="ri-share-line"></i></span>
                            <span>Share</span>
                        </a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <div class="share-options">
                    <p class="title">Share</p>
                    <div class="social-media">
                        <button class="social-media-btn"><i class="far fa-folder-open"></i></button>
                        <button class="social-media-btn"><i class="fab fa-whatsapp"></i></button>
                        <button class="social-media-btn"><i class="fab fa-instagram"></i></button>
                        <button class="social-media-btn"><i class="fab fa-twitter"></i></button>
                        <button class="social-media-btn"><i class="fab fa-facebook-f"></i></button>
                        <button class="social-media-btn"><i class="fab fa-linkedin-in"></i></button>
                    </div>
                    <div class="link-container">
                        <p class="link">
                            <?php echo $product_url; ?>
                        </p>
                        <button class="copy-btn" onclick="copyLink()">Copy</button>
                    </div>
                </div>
            </div>
            <script>
                function copyLink() {
                    var linkText = document.querySelector('.link').textContent;
                    navigator.clipboard.writeText(linkText).then(function() {
                        alert('Link copied to clipboard');
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                    });
                }
            </script>
<?php
include "../login/config.php";

// Get product ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Prepare the query
    $stmt = $conn->prepare("SELECT brand, activity, material, gender, details FROM products WHERE id = ?");
    $stmt->bind_param("i", $id); // Bind as integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the result as an associative array
    if ($product = $result->fetch_assoc()) {
        // Output HTML (example)
        // Removed the previous echo statements to avoid duplication
    } else {
        echo "Product not found.";
    }

    $stmt->close();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>
<div class="description collapse">
    <ul>
        <li class="has-child expand">
            <a href="#0" class="icon-small">Information</a>
            <ul class="content">
            <li><span>Brands</span><span><?php echo $product['brand']; ?></span></li>
            <li><span>Activity</span><span><?php echo $product['activity']; ?></span></li>
            <li><span>Material</span><span><?php echo $product['material']; ?></span></li>
            <li><span>Gender</span><span><?php echo $product['gender']; ?></span></li>
            </ul>
        </li>
        <li class="has-child">
            <a href="#0" class="icon-small">Details</a>
            <div class="content">
            <?php
                // Output additional details as paragraph
                echo "<p>{$product['details']}</p>";
                ?>
            </div>
        </li>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shareBtn = document.querySelector('#share-btn');
        const shareOptions = document.querySelector('.share-options');

        // Toggle share options when share button is clicked
        shareBtn.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default anchor tag behavior
            shareOptions.classList.toggle('active');
        });

        // Close share options when clicking outside
        document.addEventListener('click', (event) => {
            const target = event.target;
            const isShareOptionsClicked = target.closest('.share-options');
            const isShareBtnClicked = target.closest('#share-btn');

            if (!isShareOptionsClicked && !isShareBtnClicked) {
                shareOptions.classList.remove('active');
            }
        });
    });
</script>