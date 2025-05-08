<div class="single-product">
    <div class="container">
        <div class="wrapper">
            <div class="breadcrumb">
                <ul class="flexitem">
                </ul>
            </div>

            <?php
            include '../login/config.php';

            // Retrieve product data from URL
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $name = isset($_GET['name']) ? urldecode($_GET['name']) : '';
            $image = isset($_GET['image']) ? urldecode($_GET['image']) : '';
            $image = str_replace('img/', 'images_products/', $image);
            $price = isset($_GET['price']) ? $_GET['price'] : '';
            $oprice = isset($_GET['oprice']) ? $_GET['oprice'] : '';
            $discount = isset($_GET['discount']) ? $_GET['discount'] : '';

            $_SESSION['product_data'] = [
                'id' => $id,
                'name' => $name,
                'image' => $image,
                'price' => $price,
                'oprice' => $oprice,
                'discount' => $discount
            ];

            // Get product details
            $sql = "SELECT id, name, slug FROM products WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product_name = $row["name"];
                    $product_slug = $row["slug"];
                }
            } else {
                echo "Product not found";
            }
            ?>

            <div class="column">
                <div class="products one">
                    <div class="flexwrap">
                        <div class="row">
                            <div class="item is_sticky">
                                <div class="price">
                                    <a href="camera.php" target="_blank">
                                        <span class="discount"><i class="ri-camera-line"></i> Open Camera</span>
                                    </a>
                                </div>

                                <!-- Big Image Display -->
                                <div class="big-image">
                                    <div class="big-image-wrapper">
                                        <div class="image-show">
                                            <img src="../img/<?php echo $image; ?>" alt="" id="bigImage" style="cursor: pointer;">
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Prepare thumbnail images
                                $images = [];
                                $mainImage = basename($image); // Just gets 'apparel3.jpg'

                                if (!empty($mainImage)) {
                                    $images[] = $mainImage;
                                }

                                // Fetch from products_images table
                                $sql = "SELECT image FROM products_images WHERE product_id = $id";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $img = $row['image'];
                                        if ($img !== $mainImage) {
                                            $images[] = $img;
                                        }
                                    }
                                }

                                $conn->close();
                                ?>

                                <!-- Thumbnail Images -->
                                <?php if (!empty($images)): ?>
                                    <div class="small-image" thumbSlider>
                                        <ul class="small-image-wrapper flexitem">
                                            <?php foreach ($images as $thumbImage): ?>
                                                <?php if (!empty($thumbImage)): ?>
                                                    <li class="thumbnail-show">
                                                        <img src="../images_products/<?php echo htmlspecialchars($thumbImage); ?>"
                                                             alt="Product Image"
                                                             style="cursor: pointer;"
                                                             onclick="changeBigImage('../images_products/<?php echo htmlspecialchars($thumbImage); ?>')">
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- JS for Changing and Zooming Images -->
                                <script>
                                    function changeBigImage(imageUrl) {
                                        document.getElementById('bigImage').src = imageUrl;
                                    }

                                    function openFullscreen(imageUrl) {
                                        let modal = document.createElement('div');
                                        modal.style.position = 'fixed';
                                        modal.style.top = '0';
                                        modal.style.left = '0';
                                        modal.style.width = '100%';
                                        modal.style.height = '100%';
                                        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
                                        modal.style.zIndex = '9999';
                                        modal.style.display = 'flex';
                                        modal.style.justifyContent = 'center';
                                        modal.style.alignItems = 'center';
                                        modal.style.cursor = 'pointer';

                                        let fullImage = document.createElement('img');
                                        fullImage.src = imageUrl;
                                        fullImage.style.maxWidth = '90%';
                                        fullImage.style.maxHeight = '90%';
                                        fullImage.style.objectFit = 'contain';

                                        modal.appendChild(fullImage);
                                        document.body.appendChild(modal);

                                        modal.onclick = function () {
                                            modal.remove();
                                        };
                                    }

                                    // Enable full screen on big image click
                                    document.getElementById('bigImage').onclick = function () {
                                        openFullscreen(this.src);
                                    };
                                </script>
                            </div>
                        </div>

