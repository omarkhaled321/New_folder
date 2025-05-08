<?php include 'session_check.php'; ?>
<?php
include "../login/config.php";
$result = mysqli_query($conn, "SELECT id, product_id, image FROM products_images ORDER BY id DESC");
include "./confirmapplications.php";
?>
<?php
include "../login/config.php";

// Fetch products for the dropdown
$products_result = mysqli_query($conn, "SELECT id, name, image FROM products ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_sidebar.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Slider Images</title>
    <style>
.edit-button, .delete-button {
    margin: 0 5px;
    color: white; /* Change icon color */
    text-decoration: none;
    font-size: 18px; /* Adjust icon size */
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
    <?php include './admin_sidebar.php'; ?>

    <!-- Main content -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        </div>
        <!-- Add new product form -->
        <div class="add-product-form">
    <h3>Add New Slider</h3>
    <form method="POST" action="admin_add_products_images.php" enctype="multipart/form-data">
        <label for="product_id">Product:</label>
        <select id="product_id" name="product_id" required>
            <option value="">Select a product</option>
            <?php
            while ($product = mysqli_fetch_object($products_result)) {
                echo "<option value='$product->id'>$product->name</option>";
            }
            ?>
        </select>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Add Slider</button>
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
                            <th>product_id</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_object($result)) {
                            echo "<tr id='row-$row->id'>";
                            echo "<td>$row->id</td>";
                            echo "<td>$row->product_id</td>";
                            echo "<td><img src='../images_products/$row->image' alt='Image' style='width: 100px; height: 100px;' onclick='showImage(\"$row->image\")'></td>";
                            echo "<td>
                            <a href='javascript:void(0);' class='edit-button' title='Edit' 
                               onclick=\"openEditModal('$row->id', '$row->product_id')\">
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='admin_delete_products_images.php?id=$row->id' class='delete-button' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'>
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
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content fullscreen" id="modalImg">
        </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Slider</h3>
            <form id="editForm" method="POST" action="admin_update_products_images.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">

                <label for="edit_product_id">Product_id:</label>
                <input type="text" id="edit_product_id" name="product_id" required>

                <label for="edit_image">Image:</label>
                <input type="file" id="edit_image" name="image" accept="image/*">

                <button type="submit">Update</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showImage(imageName) {
            var modal = document.getElementById('myModal');
            var modalImg = document.getElementById('modalImg');
            modal.style.display = "block";
            modalImg.src = '../images_products/' + imageName;
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function openEditModal(id, product_id) {
            document.getElementById('edit_product_id').value = product_id;
            document.getElementById('edit_id').value = id;

            var modal = document.getElementById('editModal');
            modal.style.display = "block";
        }

        function closeEditModal() {
            var modal = document.getElementById('editModal');
            modal.style.display = "none";
        }
    </script>
    <script src="../js/admin.js"></script>
</body>
</html>