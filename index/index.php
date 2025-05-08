<?php session_start(); ?>
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
    <?php include './index_slider.php'; ?>
    <?php include './index_related_products.php'; ?>
    <?php include './index_selected_products.php'; ?>
    <?php include './index_banner.php'; ?>
</main>


<footer>
    <?php include '../footer/footer_newsletter.php'; ?>
    <?php include '../footer/footer_widgets.php'; ?>
    <?php include '../footer/footer_info.php'; ?>
</footer>
<?php include '../mobile_view/mobile_view.php'; ?>




</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../js/index.js"></script>
<script src="../js/search.js"></script>

