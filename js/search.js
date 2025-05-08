// ....................for search.........................................................
document.addEventListener('DOMContentLoaded', function() {
    var searchForm = document.getElementById('searchForm');
    var searchInput = document.getElementById('searchInput');

    var searchForm1 = document.getElementById('searchForm1'); // New form ID
    var searchInput1 = document.getElementById('searchInput1'); // New input ID

    // Event listener for form submission
    searchForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        search(searchInput);
    });

    // Event listener for form submission for the second form
    searchForm1.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior
        search(searchInput1);
    });

    // Function to handle search functionality
    function search(inputField) {
        // Get the search query from the input field
        var searchQuery = inputField.value.trim();

        // If the search query is not empty
        if (searchQuery !== '') {
            // Send an AJAX request to search.php with the search query
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../search/search.php?query=' + encodeURIComponent(searchQuery), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Parse the JSON response
                        var searchResults = JSON.parse(xhr.responseText);
                        // Redirect to the target page and pass the search results as URL parameters
                        window.location.href = './searcheditems.php?results=' + encodeURIComponent(JSON.stringify(searchResults));
                    } else {
                        console.error('Failed to fetch search results');
                    }
                }
            };
            xhr.send();
        }
    }

    // Function to render search results
    function renderSearchResults(results) {
        // Clear previous search results
        searchResultsContainer.innerHTML = '';

        // Check if there are any search results
        if (results.length > 0) {
            // Iterate through the search results and create HTML elements to display them
            results.forEach(function(product) {
                var productHTML = `
                <div class="item">
            <div class="media">
                <div class="thumbnail object-cover">
                    <a href="./productview.php?id=${product.id}&price=${product.price}&oprice=${product.oprice}&discount=${product.discount}&name=${encodeURIComponent(product.name)}&image=${encodeURIComponent(product.image)}">
                        <img src="${product.image}" alt="">
                    </a>
                </div>
                <div class="hoverable">
                    <ul>
                        <li class="heart-icon" data-product-id="${product.id}" data-heart-state="unfilled"><a href="#"><i class="ri-heart-line"></i></a></li>
                        <li><a href="#"><i class="ri-eye-line"></i></a></li>
                        <li><a href="#"><i class="ri-shuffle-line"></i></a></li>
                    </ul>
                </div>
                <div class="discount circle flexcenter"><span>${product.discount}</span></div>
            </div>
            <div class="content">
                <div class="rating">
                    <!-- Output rating stars based on the product's rating -->
                </div>
                <h3 class="main-links"><a href="#">${product.name}</a></h3>
                <div class="price">
                    <span class="current">$${product.price}</span>
                    <span class="normal mini-text">$${product.oprice}</span>
                </div>
                <div class="stock mini-text" data-stock="${product.stock}">
                    <div class="qty">
                        <span>Sold: <strong class="qty-sold">${product.sold}</strong></span>
                        <span>Stock: <strong class="qty-available">${product.stock}</strong></span>
                    </div>
                    <div class="bar">
                        <div class="available" style="width: ${(product.sold / product.stock) * 100}%"></div>
                    </div>
                </div>
            </div>
        </div>`;
                searchResultsContainer.innerHTML += productHTML; // Append to searchResultsContainer
            });
        } else {
            // If no results found, display a message
            searchResultsContainer.innerHTML = '<p>No products found</p>';
        }
    }
});
