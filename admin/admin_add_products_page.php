<?php include 'session_check.php'; ?>
<?php
include "../login/config.php";
$result = mysqli_query($conn, "SELECT id, storename, name, price, oprice, discount, shipping, image, stock, sold, category, brand, activity, material, gender, details FROM products ORDER BY id DESC");
include "confirmapplications.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_sidebar.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Products</title>
    <style>
        .edit-button, .delete-button {
            margin: 0 5px;
            color: white; /* Change icon color */
            text-decoration: none;
            font-size: 18px; /* Adjust icon size */
            display: inline-block;
        }
        .edit-button {
            background-color: #4CAF50; /* Green */
            padding: 5px;
            border-radius: 3px;
        }
        .delete-button {
            background-color: #f44336; /* Red */
            padding: 5px;
            border-radius: 3px;
        }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: hidden; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        #modalImg {
            width: 100vw;
            height: 100vh;
            object-fit: contain; /* or use 'cover' if you want the image to fill the entire screen */
            display: block;
            margin: auto;
            margin-top: 50px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        select {
            width: 100%; /* Full width */
            padding: 10px; /* Padding for better spacing */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px; /* Rounded corners */
            background-color: #fff; /* White background */
            font-size: 16px; /* Font size */
            color: #333; /* Dark text color */
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><polygon points="0,0 10,0 5,5" fill="%23333"/></svg>'); /* Custom arrow */
            background-repeat: no-repeat; /* Prevent repeating */
            background-position: right 10px center; /* Position the arrow */
            background-size: 10px; /* Size of the arrow */
            cursor: pointer; /* Pointer cursor on hover */
        }
        /* Style for the select on focus */
        select:focus {
            border-color: #4CAF50; /* Green border on focus */
            outline: none; /* Remove default outline */
        }
        /* Optional: Style for the select when disabled */
        select:disabled {
            background-color: #f5f5f5; /* Light gray background */
            color: #999; /* Gray text */
            cursor: not-allowed; /* Not allowed cursor */
        }
    </style>
</head>
<body>
<div class="container">
    <?php include 'admin_sidebar.php'; ?>
    <!-- Main content -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        </div>
        <!-- Add new product form -->
        <div class="add-product-form">
            <h3>Add New Product</h3>
            <form method="POST" action="admin_add_products.php" enctype="multipart/form-data">
                <label for="storename">Store Name:</label>
                <select id="storename" name="storename" required>
                    <option value="">Select Store</option>
                    <?php
                    // Fetch stores from database
                    $storeResult = mysqli_query($conn, "SELECT storename FROM stores ORDER BY storename");
                    while ($storeRow = mysqli_fetch_assoc($storeResult)) {
                        echo "<option value='{$storeRow['storename']}'>{$storeRow['storename']}</option>";
                    }
                    ?>
                </select>
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
                <label for="oprice">Original Price:</label>
                <input type="number" id="oprice" name="oprice" step="0.01">
                <label for="discount">Discount:</label>
                <input type="number" id="discount" name="discount" step="0.01">
                <label for="shipping">Shipping:</label>
                <input type="text" id="shipping" name="shipping">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
                <label for="sold">Sold:</label>
                <input type="number" id="sold" name="sold">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" required>
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" required>
                <label for="activity">Activity:</label>
                <input type="text" id="activity" name="activity">
                <label for="material">Material:</label>
                <input type="text" id="material" name="material">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender">
                <label for="details">Details:</label>
                <textarea id="details" name="details" required></textarea>
                <button type="submit">Add Product</button>
            </form>
        </div>
        <div class="table">
            <div class="table_header">
                <p>Products</p>
            </div>
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Store Name</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Original Price</th>
                            <th>Discount</th>
                            <th>Shipping</th>
                            <th>Image</th>
                            <th>Stock</th>
                            <th>Sold</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Activity</th>
                            <th>Material</th>
                            <th>Gender</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_object($result)) {
                            $imagePath = str_replace('IMAGE_PLACEHOLDER', $row->image, '../images_products/IMAGE_PLACEHOLDER');
                            echo "<tr id='row-$row->id'>";
                            echo "<td>$row->id</td>";
                            echo "<td>$row->storename</td>";
                            echo "<td>$row->name</td>";
                            echo "<td>$row->price</td>";
                            echo "<td>$row->oprice</td>";
                            echo "<td>$row->discount</td>";
                            echo "<td>$row->shipping</td>";
                            echo "<td><img src='".str_replace('IMAGE_PLACEHOLDER', $row->image, '../images_products/IMAGE_PLACEHOLDER')."' alt='Image' style='width: 100px; height: 100px;' onclick='showImage(\"$row->image\")'></td>";
                            echo "<td>$row->stock</td>";
                            echo "<td>$row->sold</td>";
                            echo "<td>$row->category</td>";
                            echo "<td>$row->brand</td>";
                            echo "<td>$row->activity</td>";
                            echo "<td>$row->material</td>";
                            echo "<td>$row->gender</td>";
                            echo "<td>$row->details</td>";
                            echo "<td>
                            <a href='javascript:void(0);' class='edit-button' title='Edit' 
                               onclick=\"openEditModal('$row->id', '$row->name', '$row->price', '$row->oprice', '$row->discount', '$row->shipping', '$row->stock', '$row->sold', '$row->category', '$row->brand')\">
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='admin_delete_products.php?id=$row->id' class='delete-button' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'>
                                <i class='fas fa-trash-alt'></i>
                            </a>
                          </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal for displaying full-size image -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <div class="modal-content">
            <h3>Edit Product</h3>
            <form id="editForm" method="POST" action="admin_update_products.php">
                <input type="hidden" id="editProductId" name="product_id">
                <label for="editName">Product Name:</label>
                <input type="text" id="editName" name="name" required>
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" name="price" step="0.01" required>
                <label for="editOprice">Original Price:</label>
                <input type="number" id="editOprice" name="oprice" step="0.01">
                <label for="editDiscount">Discount:</label>
                <input type="number" id="editDiscount" name="discount" step="0.01">
                <label for="editShipping">Shipping:</label>
                <input type="text" id="editShipping" name="shipping">
                <label for="editStock">Stock:</label>
                <input type="number" id="editStock" name="stock" required>
                <label for="editSold">Sold:</label>
                <input type="number" id="editSold" name="sold">
                <label for="editCategory">Category:</label>
                <input type="text" id="editCategory" name="category" required>
                <label for="editBrand">Brand:</label>
                <input type="text" id="editBrand" name="brand" required>
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        // Function to display full-size image in modal
        function showImage(imageName) {
            var modal = document.getElementById('myModal');
            var modalImg = document.getElementById('modalImg');
            var imageSrc = '../images_products/' + imageName; // Assuming the images are saved in the "productimages" folder
            modal.style.display = "block";
            modalImg.src = imageSrc;
        }

        // Function to close image modal
        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        }

        // Function to open edit modal
        function openEditModal(id, name, price, oprice, discount, shipping, stock, sold, category, brand) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editOprice').value = oprice;
            document.getElementById('editDiscount').value = discount;
            document.getElementById('editShipping').value = shipping;
            document.getElementById('editStock').value = stock;
            document.getElementById('editSold').value = sold;
            document.getElementById('editCategory').value = category;
            document.getElementById('editBrand').value = brand;

            var modal = document.getElementById('editModal');
            modal.style.display = "block";
        }

        // Function to close edit modal
        function closeEditModal() {
            var modal = document.getElementById('editModal');
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            var editModal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    </script>
    <script src="../js/admin.js"></script>
</body>
</html>