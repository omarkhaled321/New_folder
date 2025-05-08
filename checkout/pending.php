<?php
// process_form.php

// Start the session
session_start();

// Function to calculate 24 hours from now
$added_time = date('Y-m-d H:i:s', strtotime('+24 hours'));

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve session email
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    // Retrieve form data
    $order_numbers = isset($_POST['order_number']) ? $_POST['order_number'] : [];
    $firstName = $_POST['fname'] ?? '';
    $lastName = $_POST['lname'] ?? '';
    $streetAddress = $_POST['address'] ?? '';
    $country = $_POST['country'] ?? '';
    $state = $_POST['state'] ?? '';
    $town = $_POST['town'] ?? '';
    $zipCode = $_POST['postal'] ?? '';
    $phoneNumber = $_POST['phone'] ?? '';
    $paymentMethod = $_POST['payment'] ?? '';
    $visaCardName = $_POST['visaCardName'] ?? '';
    $visaCardNumber = $_POST['visaCardNumber'] ?? '';
    $visaCardDate = $_POST['visaCardDate'] ?? '';
    $visaCardCVV = $_POST['visaCardCVV'] ?? '';
    $masterCardName = $_POST['masterCardName'] ?? '';
    $masterCardNumber = $_POST['masterCardNumber'] ?? '';
    $masterCardDate = $_POST['masterCardDate'] ?? '';
    $masterCardCVV = $_POST['masterCardCVV'] ?? '';

    // Handle file uploads
    $target_dir = "./uploads/";
    $wish_photo_filename = '';
    if (isset($_FILES["image-wish"])) {
        $wish_target_file = $target_dir . basename($_FILES["image-wish"]["name"]);
        if (move_uploaded_file($_FILES["image-wish"]["tmp_name"], $wish_target_file)) {
            $wish_photo_filename = basename($_FILES["image-wish"]["name"]);
        }
    }

include "../login/config.php";

    // Notification settings
    $notification_name = "Crazy Sale";
    $notification_email = "crazysaleofficially.com";
    $time = date('Y-m-d H:i:s');
    $is_read = 0;

    foreach ($order_numbers as $key => $order_number) {
        $product_id = $_POST['product_id'][$key] ?? '';
        $image = $_POST['image'][$key] ?? '';
        $name = $_POST['name'][$key] ?? '';
        $price = $_POST['price'][$key] ?? '';
        $qty = $_POST['qty'][$key] ?? '';
        $subtotal = $_POST['subtotal'][$key] ?? '';
        $size = $_POST['size'][$key] ?? '';

        $size_parts = explode(' - ', $size);
        $sizenumber = isset($size_parts[0]) ? trim($size_parts[0]) : '';
        $size_name = isset($size_parts[1]) ? trim($size_parts[1]) : '';

        // Insert into pending
        $pending_sql = "INSERT INTO pending (
            product_id, order_number, image, name, price, qty, subtotal, email, 
            first_name, last_name, street_address, country, state, town, zip_code, 
            phone_number, payment_method, visa_card_name, visa_card_number, 
            visa_expiry_date, visa_CVV, master_card_name, master_card_number, 
            master_expiry_date, master_CVV, wish_image, added_time, sizenumber, size
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $pending_sql);
        mysqli_stmt_bind_param($stmt, "ssssddsssssssssssssssssssssss",
            $product_id, $order_number, $image, $name, $price, $qty, $subtotal, $email,
            $firstName, $lastName, $streetAddress, $country, $state, $town, $zipCode,
            $phoneNumber, $paymentMethod, $visaCardName, $visaCardNumber,
            $visaCardDate, $visaCardCVV, $masterCardName, $masterCardNumber,
            $masterCardDate, $masterCardCVV, $wish_photo_filename, $added_time,
            $sizenumber, $size_name
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Insert notification
        $content = "Order Number: $order_number, Product Name: $name, Quantity: $qty, Subtotal: $subtotal. Your order has been placed successfully.";
        $notif_sql = "INSERT INTO main_notifications (name, email, reciever_email, content, time, is_read) VALUES (?, ?, ?, ?, ?, ?)";
        $notif_stmt = mysqli_prepare($conn, $notif_sql);
        mysqli_stmt_bind_param($notif_stmt, "sssssi", $notification_name, $notification_email, $email, $content, $time, $is_read);
        mysqli_stmt_execute($notif_stmt);
        mysqli_stmt_close($notif_stmt);
    }

    // Clear cart
    $clear_cart_sql = "DELETE FROM cart WHERE email = ?";
    $cart_stmt = mysqli_prepare($conn, $clear_cart_sql);
    mysqli_stmt_bind_param($cart_stmt, "s", $email);
    mysqli_stmt_execute($cart_stmt);
    mysqli_stmt_close($cart_stmt);

    mysqli_close($conn);

    // Redirect
    header("Location: ../delivery/delivery.php");
    exit();
}
?>
