<?php
// Include the database configuration file
include "../login/config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $storename = $name = $price = $oprice = $discount = $shipping = $image = $stock = $sold = $category = $brand = $activity = $material = $gender = $details = "";

    // Retrieve form data using $_POST
    $storename = trim($_POST["storename"]);
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $oprice = trim($_POST["oprice"]);
    $discount = trim($_POST["discount"]);
    $shipping = trim($_POST["shipping"]);
    $image = $_FILES["image"]["name"]; // File name
    $stock = trim($_POST["stock"]);
    $sold = trim($_POST["sold"]);
    $category = trim($_POST["category"]);
    $brand = trim($_POST["brand"]);
    $activity = trim($_POST["activity"]);
    $material = trim($_POST["material"]);
    $gender = trim($_POST["gender"]);
    $details = trim($_POST["details"]);

    // Upload image file to server
    $targetDir = "../images_products/"; // Specify the target directory where the image will be stored
    $targetFilePath = $targetDir . $image; // Combine target directory with the file name
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Prepare an insert statement
    $sql = "INSERT INTO products (storename, name, price, oprice, discount, shipping, image, stock, sold, category, brand, activity, material, gender, details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssddddssdssssss", $param_storename, $param_name, $param_price, $param_oprice, $param_discount, $param_shipping, $param_image, $param_stock, $param_sold, $param_category, $param_brand, $param_activity, $param_material, $param_gender, $param_details);

        // Set parameters
        $param_storename = $storename;
        $param_name = $name;
        $param_price = $price;
        $param_oprice = $oprice;
        $param_discount = $discount;
        $param_shipping = $shipping;
        $param_image = $image;
        $param_stock = $stock;
        $param_sold = $sold;
        $param_category = $category;
        $param_brand = $brand;
        $param_activity = $activity;
        $param_material = $material;
        $param_gender = $gender;
        $param_details = $details;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to success page
            header("location: admin_add_products_page.php");
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
