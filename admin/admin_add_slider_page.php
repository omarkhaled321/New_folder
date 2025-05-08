<?php include 'session_check.php'; ?>
<?php
include "../login/config.php";
$result = mysqli_query($conn, "SELECT id, image, title1, title2, subtitle, button_text, button_link FROM slider_sales ORDER BY id DESC");
include "./confirmapplications.php";
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
            overflow: auto; /* Enable scroll if needed */
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
            <form method="POST" action="admin_add_slider.php" enctype="multipart/form-data">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <label for="title1">Title1:</label>
                <input type="text" id="title1" name="title1" required>

                <label for="title2">Title2:</label>
                <input type="text" id="title2" name="title2" required>

                <label for="subtitle">Subtitle:</label>
                <input type="text" id="subtitle" name="subtitle">

                <label for="button_text">Button Text:</label>
                <input type="text" id="button_text" name="button_text">

                <label for="button_link">Button Link:</label>
                <input type="text" id="button_link" name="button_link">

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
                            <th>Image</th>
                            <th>Title 1</th>
                            <th>Title 2</th>
                            <th>Subtitle</th>
                            <th>Button Text</th>
                            <th>Button Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
 <tbody>
                        <?php
                        while ($row = mysqli_fetch_object($result)) {
                            echo "<tr id='row-$row->id'>";
                            echo "<td>$row->id</td>";
                            echo "<td><img src='slider_images/$row->image' alt='Image' style='width: 100px; height: 100px;' onclick='showImage(\"$row->image\")'></td>";
                            echo "<td>$row->title1</td>";
                            echo "<td>$row->title2</td>";
                            echo "<td>$row->subtitle</td>";
                            echo "<td>$row->button_text</td>";
                            echo "<td>$row->button_link</td>";
                            echo "<td>
                            <a href='javascript:void(0);' class='edit-button' title='Edit' 
                               onclick=\"openEditModal('$row->id', '$row->title1', '$row->title2', '$row->subtitle', '$row->button_text', '$row->button_link')\">
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='./admin_delete_slider.php?id=$row->id' class='delete-button' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'>
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
        <img class="modal-content" id="modalImg">
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>Edit Slider</h3>
            <form id="editForm" method="POST" action="admin_update_slider.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <label for="edit_image">Image:</label>
                <input type="file" id="edit_image" name="image" accept="image/*">

                <label for="edit_title1">Title 1:</label>
                <input type="text" id="edit_title1" name="title1" required>

                <label for="edit_title2"> Title 2:</label>
                <input type="text" id="edit_title2" name="title2" required>

                <label for="edit_subtitle">Subtitle:</label>
                <input type="text" id="edit_subtitle" name="subtitle">

                <label for="edit_button_text">Button Text:</label>
                <input type="text" id="edit_button_text" name="button_text">

                <label for="edit_button_link">Button Link:</label>
                <input type="text" id="edit_button_link" name="button_link">

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
            modalImg.src = 'slider_images/' + imageName;
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

        function openEditModal(id, title1, title2, subtitle, buttonText, buttonLink) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_title1').value = title1;
            document.getElementById('edit_title2').value = title2;
            document.getElementById('edit_subtitle').value = subtitle;
            document.getElementById('edit_button_text').value = buttonText;
            document.getElementById('edit_button_link').value = buttonLink;

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