
<div class="section">
<div class="row">
    <div class="cat-head">                                      
        <div class="cat-navigation flexitem">
             <div class="item-filter desktop-hide">
                <a href="#" class="filter-trigger label">
                    <i class="ri-menu-2-line ri-2x"></i>
                    <span>Filter</span>
                </a>
            </div>
             <div class="item-options">
                <div class="label">
                    <span class="mobile-hide">Sort by default</span>
                    <div class="desktop-hide">Default</div>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <ul id="sortOptions">
                <li onclick="sortProducts('name')">Product Name</li>
                <li onclick="sortProducts('price')">Price</li>
                </ul>
            </div> 
        </div>
    </div>
</div>
<!-- featured items---------------------------------------------------------------------------------------------------------------------------------------- -------------------------------------------------------->
<div class="products main flexwrap" id="productList">
<?php
include 'functions.php';

// Retrieve the selected category
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Call the function to fetch products
$products = fetchProducts($category);

// Output the products
if (is_array($products)) {
    foreach ($products as $product) {
        // Output product HTML
        echo "<div class='item'>";
        echo "<div class='media'>";
        echo "<div class='thumbnail object-cover'>";
        echo "<a href='../product_view/product_view.php?id=" . $product["id"] . "&price=" . $product["price"] . "&oprice=" . $product["oprice"] . "&discount=" . $product["discount"] . "&name=" . urlencode($product["name"]) . "&image=" . urlencode($product["image"]) . "'>";
        echo "<img src='../img/" . $product["image"] . "' alt=''>";
        echo "</a>";
        echo "</div>";
        echo "<div class='hoverable'>";
        echo "<ul>";
        // Add onclick event to heart icon to toggle color
        echo "<li class='heart-icon' data-product-id='" . $product["id"] . "' data-heart-state='unfilled'><a href='#'><i class='ri-heart-line'></i></a></li>";
        echo "<li><a href='#'><i class='ri-eye-line'></i></a></li>";
        echo "<li><a href='#'><i class='ri-shuffle-line'></i></a></li>";
        echo "</ul>";
        echo "</div>";
        echo "<div class='discount circle flexcenter'><span>" . $product["discount"] . "</span></div>";
        echo "</div>";
        echo "<div class='content'>";
        echo "<div class='rating'>";
        // Output rating stars based on the product's rating
        echo "</div>";
        echo "<h3 class='main-links'><a href='#'>" . $product["name"] . "</a></h3>";
        echo "<div class='price'>";
        echo "<span class='current'>$" . $product["price"] . "</span>";
        echo "<span class='normal mini-text'>$" . $product["oprice"] . "</span>";
        echo "</div>";
        // Output stock data
        echo "<div class='stock mini-text' data-stock='" . $product["stock"] . "'>";
        echo "<div class='qty'>";
        echo "<span>Sold: <strong class='qty-sold'>" . $product["sold"] . "</strong></span>";
        echo "<span>Stock: <strong class='qty-available'>" . $product["stock"] . "</strong></span>";
        echo "</div>";
        echo "<div class='bar'>";
        echo "<div class='available' style='width: " . (($product["sold"] / $product["stock"]) * 100) . "%'></div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo $products;
}
?>


<script>
    function sortProducts(criteria) {
        const productList = document.getElementById('productList');
        let products = Array.from(productList.children);

        if (criteria === 'name') {
            products.sort((a, b) => {
                const nameA = a.querySelector('.main-links a').textContent.toUpperCase();
                const nameB = b.querySelector('.main-links a').textContent.toUpperCase();
                return nameA.localeCompare(nameB);
            });
        } else if (criteria === 'price') {
            products.sort((a, b) => {
                const priceA = parseFloat(a.querySelector('.current').textContent.replace('$', ''));
                const priceB = parseFloat(b.querySelector('.current').textContent.replace('$', ''));
                return priceA - priceB;
            });
        } else {
            // Default sorting
        }

        // Clear current product list
        productList.innerHTML = '';

        // Append sorted products
        products.forEach(product => productList.appendChild(product));
    }
</script>



                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateCategory(category) {
        var form = document.getElementById('categoryForm');
        // Remove any existing hidden inputs for category
        var existingInputs = form.querySelectorAll('input[name="category"]');
        existingInputs.forEach(function(input) {
            form.removeChild(input);
        });
        // Create and add the new hidden input
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'category';
        input.value = category;
        form.appendChild(input);
        form.submit();
    }
</script>
<script>
    // Function to sort spans alphabetically
function sortSpansAlphabetically() {
    // Get the ul element
    var ul = document.querySelector('#categoryForm ul');
    
    // Get all li elements
    var lis = ul.getElementsByTagName('li');
    
    // Create an array to hold the lis
    var liArr = Array.prototype.slice.call(lis);

    // Sort the array alphabetically based on the category name
    liArr.sort(function(a, b) {
        var spanA = a.querySelector('.category-name').textContent.trim().toLowerCase();
        var spanB = b.querySelector('.category-name').textContent.trim().toLowerCase();
        if (spanA < spanB) return -1;
        if (spanA > spanB) return 1;
        return 0;
    });

    // Append sorted lis back to ul
    liArr.forEach(function(li) {
        ul.appendChild(li);
    });
}

// Call the function to sort spans alphabetically
sortSpansAlphabetically();

</script>
<script>
    const FtoShow = '.filter';
    const Fpopup = document.querySelector(FtoShow);
    const Ftrigger = document.querySelector('.filter-trigger');

    Ftrigger.addEventListener('click', () => {
    setTimeout(() => {
        if(!Fpopup.classList.contains('show')){
            Fpopup.classList.add('show')
        }
    }, 250 )
})

// auto close by click outside .filter
document.addEventListener('click', (e) => {
    const isClosest = e.target.closest(FtoShow);
    if(!isClosest && Fpopup.classList.contains('show')) {
        Fpopup.classList.remove('show')
    }
})
</script>