<?php
include "../login/config.php"; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $storename = $_POST['storename'];
    $country = $_POST['country'];
    $logo = $_FILES['logo'];

    // Prepare the SQL update statement
    $sql = "UPDATE stores SET storename = ?, country = ?";

    // Check if a new logo is uploaded
    if (!empty($logo['name'])) {
        // Handle file upload
        $targetDir = "images_stores_logo/";
        $targetFile = $targetDir . basename($logo["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($logo["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Check file size (limit to 2MB)
        if ($logo["size"] > 2000000) {
            die("Sorry, your file is too large.");
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($logo["tmp_name"], $targetFile)) {
            // If a new logo is uploaded, include it in the update statement
            $sql .= ", logo = ?";
            $params = [$storename, $country, $logo["name"], $id];
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        // If no new logo is uploaded, just update the store name and country
        $params = [$storename, $country, $id];
    }

    // Prepare the statement
    if (!empty($logo['name'])) {
        // If logo is uploaded, we bind 4 parameters
        $stmt = $conn->prepare($sql . " WHERE id = ?");
        $stmt->bind_param("sssi", ...$params);  // "sssi" for 3 strings + 1 integer
    } else {
        // If no logo is uploaded, we bind 3 parameters
        $stmt = $conn->prepare($sql . " WHERE id = ?");
        $stmt->bind_param("ssi", ...$params);  // "ssi" for 2 strings + 1 integer
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Store updated successfully.";
    } else {
        echo "Error updating store: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the stores page (optional)
    header("Location: admin_add_stores_page.php");
    exit();
} else {
    // If the request method is not POST, redirect to the stores page
    header("Location: admin_add_stores_page.php");
    exit();
}
?>
