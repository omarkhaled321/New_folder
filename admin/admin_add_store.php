<?php
include "../login/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $logo = $_FILES["logo"]["name"];
    $storename = $_POST["storename"];
    $country = $_POST["country"];

    // File paths
    $logo_path = "images_stores_logo/" . basename($logo);

    // Move uploaded file to the specified directory
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $logo_path)) {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO stores (logo, storename, country) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $logo, $storename, $country);

        if ($stmt->execute() === TRUE) {
            // Redirect to stores page after successful insertion
            header("Location: admin_add_stores_page.php");
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
