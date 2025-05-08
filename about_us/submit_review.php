<?php
// Database connection details
include "../login/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $content = $_POST['content'];
    $time = date('Y-m-d H:i:s');

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO companyreviews (name, content, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $content, $time);

    if ($stmt->execute()) {
        echo "<script>alert('New review submitted successfully'); window.location.href='info_company_reviews.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='info_company_reviews.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
