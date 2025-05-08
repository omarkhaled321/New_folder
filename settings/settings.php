<?php
session_start(); // Start the session

// Include your config file
include "../login/config.php";

// Check if email session variable is set
if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit;
}

$email = $_SESSION['email'];

// Fetch username based on email
$sql = "SELECT username FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row["username"];
    // Set $username as a session variable if needed on other pages
    $_SESSION['username'] = $username;
} else {
    // Handle case where no user is found
    $_SESSION['message'] = "No user found with the provided email.";
    $_SESSION['message_type'] = 'red';
    header("Location: settings.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
    if (isset($_FILES["fileImg"]["name"])) {
        $src = $_FILES["fileImg"]["tmp_name"];
        $imageName = $_FILES["fileImg"]["name"];
        $target = "./profileimg/" . $imageName;

        // Ensure the target directory exists
        if (!is_dir('./profileimg')) {
            mkdir('./profileimg', 0777, true);
        }

        if (move_uploaded_file($src, $target)) {
            $query = "UPDATE users SET image = '$imageName' WHERE email = '$email'";
            if (mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Profile picture updated successfully.";
                $_SESSION['message_type'] = 'green';
                header("Location: settings.php");
                exit;
            } else {
                $_SESSION['message'] = "Error updating image: " . mysqli_error($conn);
                $_SESSION['message_type'] = 'red';
                header("Location: settings.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "Error moving uploaded file.";
            $_SESSION['message_type'] = 'red';
            header("Location: settings.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "No file uploaded.";
        $_SESSION['message_type'] = 'red';
        header("Location: settings.php");
        exit;
    }
}
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save_password_changes'])) {
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if ($new_password !== $confirm_password) {
            $_SESSION['message'] = "New password and confirm password do not match";
            $_SESSION['message_type'] = 'red';
            header("Location: settings.php");
            exit;
        } else {
            // Verify current password
            $email = $_SESSION['email'];
            $sql = "SELECT password FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                if (password_verify($current_password, $hashed_password)) {
                    // Generate OTP
                    $otp = rand(100000, 999999);
                    $_SESSION['otp'] = $otp;
                    $_SESSION['new_password'] = password_hash($new_password, PASSWORD_DEFAULT);

                    // Send OTP to user's email
                    require "./Mail/phpmailer/PHPMailerAutoload.php";
                    $mail = new PHPMailer;

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';

                    $mail->Username = 'jalalsahloul81@gmail.com'; // Replace with your email address
                    $mail->Password = 'ajvr wuli ilxv pftm'; // Replace with your email password

                    $mail->setFrom('your-email@gmail.com', 'OTP Verification');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = "Your OTP for Password Change";
                    $mail->Body = "<p>Dear user,</p><p>Your OTP (One-Time Password) for changing your password is: $otp</p><p>Regards,<br>Crazy Sale</p>";

                    if ($mail->send()) {
                        $_SESSION['message'] = "OTP has been sent to your email";
                        $_SESSION['message_type'] = 'green';
                        header("Location: ./settings_otp.php");
                        exit;
                    } else {
                        $_SESSION['message'] = "Failed to send OTP";
                        $_SESSION['message_type'] = 'red';
                        header("Location: settings.php");
                        exit;
                    }
                } else {
                    $_SESSION['message'] = "Invalid current password";
                    $_SESSION['message_type'] = 'red';
                    header("Location: settings.php");
                    exit;
                }
            } else {
                $_SESSION['message'] = "Invalid current password";
                $_SESSION['message_type'] = 'red';
                header("Location: settings.php");
                exit;
            }
        }
    }

        
    
    if (isset($_POST["change_info"])) {
        // Update other user information
        $email = $_SESSION['email'];
        $birthday = $_POST['birthday'];
        $country = $_POST['country'];
    
        $update_info_sql = "UPDATE users SET birthday='$birthday', country='$country' WHERE email='$email'";
        if (mysqli_query($conn, $update_info_sql)) {
            $_SESSION['alert'] = [
                "type" => "success",
                "message" => "Info has been changed"
            ];
            header("Location: settings.php");
            exit;
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "message" => "Error updating info: " . mysqli_error($conn)
            ];
            header("Location: settings.php");
            exit;
        }
    }}
    
    // Check if the form was submitted
    if (isset($_POST["change_contacts"])) {
        // Check if the contacts field is set in the POST array
        if (isset($_POST['contacts'])) {
            // Update contacts information
            $email = $_SESSION['email'];
            $contacts = mysqli_real_escape_string($conn, $_POST['contacts']);
            
            $update_contacts_sql = "UPDATE users SET contacts='$contacts' WHERE email='$email'";
            if (mysqli_query($conn, $update_contacts_sql)) {
                $_SESSION['alert'] = [
                    "type" => "success",
                    "message" => "Contacts have been changed"
                ];
            } else {
                $_SESSION['alert'] = [
                    "type" => "danger",
                    "message" => "Error updating contacts: " . mysqli_error($conn)
                ];
            }
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "message" => "Contacts field is required"
            ];
        }
        header("Location: settings.php");
        exit;
    }
    
    $email = $_SESSION['email'];
    $user_result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($user_result);
?>
<?php
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    echo "<div class='alert alert-{$alert['type']}'>{$alert['message']}</div>";
    unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fslightbox@3.2.7/dist/fslightbox.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/settings.css">
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

   <?php include './settings_main.php'; ?>

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
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/index.js"></script>
<script src="../js/settings.js"></script>