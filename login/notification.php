<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <!------ Include the above in your HEAD tag ---------->
    <title>Login Form</title>
</head>
<style>
body { margin-top:30px; }
hr.message-inner-separator {
    clear: both;
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    height: 1px;
    background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
}
.container {
    position: absolute;
    left: 30%;
}
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="alert alert-success" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="glyphicon glyphicon-ok"></span> <strong>Success Message</strong>
                    <hr class="message-inner-separator">
                    <p>Email sent out! Kindly check your email inbox. <i class="fas fa-envelope" style="color: black;"></i></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeAlert() {
            // Redirect to login page or any other page
            window.location.href = "../login/login.php"; // Replace with your login page URL
        }
    </script>
</body>
</html>
