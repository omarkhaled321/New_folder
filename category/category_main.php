
<div class="single-category">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="holder">
                        </form>
                        <?php
include "../login/config.php";

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }
} else {
  echo "0 results";
}
$conn->close();
// Sort categories by shownname
usort($categories, function($a, $b) {
    return strcmp($a['shownname'], $b['shownname']);
});
?>
<div class="section">
    <!-- Images Filter Buttons Section -->
    <div class="row mt-5" id="filter-buttons">
        <div class="col-12">
            <button class="btn mb-2 me-1 active" data-filter="all">Show all</button>
            <?php foreach ($categories as $category): ?>
                <button class="btn mb-2 mx-1" data-filter="<?php echo strtolower($category['name']); ?>">
                    <?php echo $category['shownname']; ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Filterable Images / Cards Section -->
    <div class="row px-2 mt-4 gap-3" id="filterable-cards">
        <?php foreach ($categories as $category): ?>
            <div class="card p-0" data-name="<?php echo strtolower($category['name']); ?>">
                <a href="category.php?category=<?php echo urlencode($category['name']); ?>">
                    <img src="img/<?php echo $category['image']; ?>" alt="<?php echo $category['shownname']; ?>">
                </a>
                <div class="card-body">
                    <h6 class="card-title"><?php echo $category['shownname']; ?></h6>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<script>
    // Select relevant HTML elements
const filterButtons = document.querySelectorAll("#filter-buttons button");
const filterableCards = document.querySelectorAll("#filterable-cards .card");

// Function to filter cards based on filter buttons
const filterCards = (e) => {
    document.querySelector("#filter-buttons .active").classList.remove("active");
    e.target.classList.add("active");

    filterableCards.forEach(card => {
        // show the card if it matches the clicked filter or show all cards if "all" filter is clicked
        if(card.dataset.name === e.target.dataset.filter || e.target.dataset.filter === "all") {
            return card.classList.replace("hide", "show");
        }
        card.classList.add("hide");
    });
}

filterButtons.forEach(button => button.addEventListener("click", filterCards));
</script>

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