<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $selected_size = $_POST['selected_size'];
    $selected_sizenumber = $_POST['selected_sizenumber'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    include "../login/config.php";

    $stmt = mysqli_prepare($conn, "INSERT INTO cart (email, product_id, name, image, price, qty, size, sizenumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sissdiis", $email, $product_id, $name, $image, $price, $quantity, $selected_size, $selected_sizenumber);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ./cart.php");
            exit;
        } else {
            echo "Error executing statement: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
