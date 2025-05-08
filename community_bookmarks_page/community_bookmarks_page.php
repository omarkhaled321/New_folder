<?php
session_start(); // Start the session

// Check if email session variable is set
if (!isset($_SESSION['email'])) {
    // If not set, redirect to login page
    header("Location: ../login/login.php");
    exit(); // Ensure no further code is executed
}

// Include your config file
include "../login/config.php";

// Assume $conn is the established database connection from config.php
$email = $_SESSION['email'];

// Prepare and execute SQL query to fetch username and profile picture
$sql = "SELECT id, username, image FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $sessionUserID = $row["id"]; // Adding user ID to session variables
        $sessionUsername = $row["username"];
        $sessionProfilePic = $row["image"];
        
        // Set $sessionUserID, $sessionUsername, and $sessionProfilePic as session variables
        $_SESSION['user_id'] = $sessionUserID;
        $_SESSION['username'] = $sessionUsername;
        $_SESSION['image'] = $sessionProfilePic;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" >

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/community.css">
    <link rel="stylesheet" href="../css/community_messages.css">
    <link rel="stylesheet" href="../css/community_story.css">
    <link rel="stylesheet" href="../css/bookmarks.css">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
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
    <?php include '../community_sidebar/community_sidebar.php'; ?>
    <?php include './community_bookmarks_page_main.php'; ?>

</main>


<footer>
    <?php include '../footer/footer_newsletter.php'; ?>
    <?php include '../footer/footer_widgets.php'; ?>
    <?php include '../footer/footer_info.php'; ?>
</footer>
<?php include '../mobile_view/mobile_view.php'; ?>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fslightbox@3.2.7/dist/fslightbox.js"></script>
<script src="../js/index.js"></script>
<script src="../js/community.js"></script>