<?php
// Include the database configuration file
include "../login/config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $image = $title1 = $title2 = $subtitle = $button_text = $button_link = "";

    // Retrieve form data using $_POST
    $image = $_FILES["image"]["name"]; // File name
    $title1 = trim($_POST["title1"]);
    $title2 = trim($_POST["title2"]);
    $subtitle = trim($_POST["subtitle"]);
    $button_text = trim($_POST["button_text"]);
    $button_link = trim($_POST["button_link"]);

    // Upload image file to server
    $targetDir = "slider_images/"; // Specify the target directory where the image will be stored
    $targetFilePath = $targetDir . $image; // Combine target directory with the file name
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Prepare an insert statement
    $sql = "INSERT INTO slider_sales (image, title1, title2, subtitle, button_text, button_link) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssdddd", $param_image, $param_title1, $param_title2, $param_subtitle, $param_button_text, $param_button_link);

        // Set parameters
        $param_image = $image;
        $param_title1 = $title1;
        $param_title2 = $title2;
        $param_subtitle = $subtitle;
        $param_button_text = $button_text;
        $param_button_link = $button_link;
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to success page
            header("location: admin_add_slider_page.php");
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
