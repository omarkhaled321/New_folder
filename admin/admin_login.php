<?php
session_start();

$users = [
    'jalalsahloul81@gmail.com' => password_hash('111', PASSWORD_BCRYPT) // Replace 'your_password' with a strong password
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['loggedin'] = true;
        header("Location: ./admin.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>
