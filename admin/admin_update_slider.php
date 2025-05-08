<?php
include "../login/config.php"; // Include your database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $title1 = $_POST['title1'];
    $title2 = $_POST['title2'];
    $subtitle = $_POST['subtitle'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];

    // Initialize the query
    $query = "UPDATE slider_sales SET title1='$title1', title2='$title2', subtitle='$subtitle', button_text='$button_text', button_link='$button_link' WHERE id='$id'";

    // Handle file upload if a new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "slider_images/"; // Directory where images will be uploaded
        $target_file = $target_dir . basename($image);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Update the database with the new image
            $query = "UPDATE slider_sales SET image='$image', title1='$title1', title2='$title2', subtitle='$subtitle', button_text='$button_text', button_link='$button_link' WHERE id='$id'";
        } else {
            // Handle error if the file could not be uploaded
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect back to the slider management page with a success message
        header("Location: ./admin_add_slider_page.php?message=Slider updated successfully");
        exit;
    } else {
        // Handle error if the query fails
        echo "Error updating record: " . mysqli_error($conn);
        echo "<br>Query: " . $query; // Output the query for debugging
    }
}

// Close the database connection
mysqli_close($conn);
?>