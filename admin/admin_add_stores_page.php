<?php include 'session_check.php'; ?>
<?php
include "../login/config.php";
$result = mysqli_query($conn, "SELECT id, logo, storename, country FROM stores ORDER BY id DESC");
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
    <title>Stores</title>
    <style>
        /* Style for modal */
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
.modal-img {
    width: 100%;
    height: auto;
}
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
    </style>
</head>
<body>
<div class="container">
    <?php include 'admin_sidebar.php' ?>

    <!-- Main content -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        </div>
        <!-- Add new store form -->
        <div class="add-store-form">
            <h3>Add New Store</h3>
            <form method="POST" action="admin_add_store.php" enctype="multipart/form-data">
                <label for="logo">Logo:</label>
                <input type="file" id="logo" name="logo" accept="image/*" required>
                <label for="storename">Store Name:</label>
                <input type="text" id="storename" name="storename" required>
                <label for="country">Country:</label>
                <select id="country" name="country" required>
                    <option value="">Select Country</option>
                    <option value="LB">Lebanon</option>
                    <!-- Add more countries as needed -->
                </select>
                <button type="submit">Add Store</button>
            </form>
        </div>
        <div class="table">
            <div class="table_header">
                <p>Stores</p>
            </div>
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Store Name</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_object($result)) {
                            echo "<tr id='row-$row->id'>";
                            echo "<td>$row->id</td>";
                            echo "<td><img src='images_stores_logo/$row->logo' alt='Logo' style='width: 100px; height: 100px;' onclick='showImage(\"$row->logo\")'></td>";
                            echo "<td>$row->storename</td>";
                            echo "<td>$row->country</td>";
                            echo "<td>
                                <a href='javascript:void(0);' class='edit-button' title='Edit' 
                                   onclick=\"openEditModal('$row->id', '$row->storename', '$row->country', '$row->logo')\">
                                    <i class='fas fa-edit'></i>
                                </a>
                          <a href='admin_delete_stores.php?id=$row->id' class='delete-button' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'>
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
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Store</h3>
            <form id="editForm" method="POST" action="admin_update_stores.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <label for="edit_storename">Store Name:</label>
                <input type="text" id="edit_storename" name="storename" required>

                <label for="edit_country">Country:</label>
                <select id="edit_country" name="country" required>
                    <option value="LB">Lebanon</option>
                    <!-- Add more countries as needed -->
                </select>

                <label for="edit_logo">Current Logo:</label>
                <img id="edit_logo" src="" alt="Current Logo" style="width: 100px; height: 100px;">

                <label for="edit_new_logo">New Logo:</label>
                <input type="file" id="edit_new_logo" name="logo" accept="image/*">

                <button type="submit">Update</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to display full-size image in modal
    function showImage(imageName) {
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById('modalImg');
        var imageSrc = 'images_stores_logo/' + imageName; 
        modal.style.display = "block";
        modalImg.src = imageSrc;
    }

    // Function to close modal
    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = "none";
    }

    // Function to open edit modal
    function openEditModal(id, storename, country, logo) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_storename').value = storename;
        document.getElementById('edit_country').value = country;
        document.getElementById('edit_logo').src = 'images_stores_logo/' + logo; 

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
        if (event.target == modal) {
            modal.style.display = "none";
        }
        var editModal = document.getElementById('editModal');
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
</script>
<script src="../js/admin.js"></script>
</body>
</html>