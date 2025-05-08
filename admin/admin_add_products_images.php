<?php
// Include the database configuration file
include "../login/config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $image = $product_id = "";

    // Retrieve form data using $_POST
    $product_id = trim($_POST["product_id"]);
    $image = $_FILES["image"]["name"]; // File name
    // Upload image file to server
    $targetDir = "../images_products/"; // Specify the target directory where the image will be stored
    $targetFilePath = $targetDir . $image; // Combine target directory with the file name
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Prepare an insert statement
    $sql = "INSERT INTO products_images (product_id, image) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_product_id, $param_image);

        // Set parameters
        $param_product_id = $product_id;
        $param_image = $image;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to success page
            header("location: admin_add_products_images_page.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
}
?>
