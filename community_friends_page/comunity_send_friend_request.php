<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../login/login.php");
    exit;
}

$currentUserEmail = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['receiverEmail'])) {
    $receiverEmail = $_POST['receiverEmail'];

    // Connect to your database
include "../login/config.php";
    $sqlCheckRequest = "SELECT * FROM friend_requests WHERE sender_email = '$currentUserEmail' AND receiver_email = '$receiverEmail'";
    $result = $conn->query($sqlCheckRequest);

    if ($result->num_rows == 0) {
        $sqlInsertRequest = "INSERT INTO friend_requests (sender_email, receiver_email) VALUES ('$currentUserEmail', '$receiverEmail')";

        if ($conn->query($sqlInsertRequest) === TRUE) {
            echo "Friend request sent successfully.";
        } else {
            echo "Error: " . $sqlInsertRequest . "<br>" . $conn->error;
        }
    } else {
        echo "Friend request already sent.";
    }

    $conn->close();
}
?>
