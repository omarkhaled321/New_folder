<?php
    session_start(); // Start the session

    // Include your config file
    include "../login/config.php";

    // Check if email session variable is set
    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Assume $conn is the established database connection from config.php

        // Prepare and execute SQL query
        $sql = "SELECT username FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $username = $row["username"];
                // Set $username as a session variable if needed on other pages
                $_SESSION['username'] = $username;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fslightbox@3.2.7/dist/fslightbox.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Index</title>
</head>
<body>

<header>
    <?php include '../header/header_aside.php'; ?>
    <?php include '../header/header_top.php'; ?>
    <?php include '../header/header_nav.php'; ?>
    <?php include '../header/header_cart.php'; ?>
    <?php include '../header/header_wishlist.php'; ?>
    <?php include '../header/header_delivery.php'; ?>
    <?php include '../header/header_notifications.php'; ?>
    <?php include '../header/header_main.php'; ?>

</header>

<main>

   <?php include './info_omt_wish_main.php'; ?>

</main>


<footer>
    <?php include '../footer/footer_newsletter.php'; ?>
    <?php include '../footer/footer_widgets.php'; ?>
    <?php include '../footer/footer_info.php'; ?>
</footer>
<?php include '../mobile_view/mobile_view.php'; ?>




</body>
</html>
<script src="../js/index.js"></script>