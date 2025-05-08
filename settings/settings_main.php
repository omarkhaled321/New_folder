<form class="form" id="form" action="" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="container light-style flex-grow-1 container-p-y">
            <h4 class="font-weight-bold py-3 mb-4">Profile</h4>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-verification">Account Verification</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-contacts">Phone</a>
                            <a class="list-group-item list-group-item-action"  href="../login/signout.php">Sign Out</a>
                        </div>
                    </div>
                    <div class="profile">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="account-general">
                                <div class="card-body media align-items-center">
                                <img src="../img/<?php echo $user['image']; ?>" id="image" style="width: 200px; height: 200px;">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" name="fileImg" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <button type="button" class="btn btn-default md-btn-flat" id="resetButton">Reset</button>
                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo $user['username']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" value="<?php echo $user['email']; ?>" readonly>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-primary" id="confirm" name="save_changes">Save changes</button>&nbsp;
                                        <button type="button" class="btn btn-default" id="cancel">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // Include PHPMailer autoload file
                            require '../vendor/autoload.php'; // Assuming PHPMailer is installed via Composer
                            
                            use PHPMailer\PHPMailer\PHPMailer;
                            use PHPMailer\PHPMailer\Exception;
                            
                            // SMTP Configuration (Gmail example)
                            $mail = new PHPMailer(true);
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'jalalsahloul81@gmail.com'; // Your Gmail email address
                            $mail->Password = 'ajvr wuli ilxv pftm'; // Your Gmail password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;
                            
                            // Define database constants if they are not already defined
                            include "../login/config.php";
                            
                            // Fetch verify_status from the users table for the logged-in user by email
                            if (isset($_SESSION['email'])) {
                                $user_email = $_SESSION['email'];
                                
                                $query = "SELECT verify_status FROM users WHERE email = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $user_email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $user = $result->fetch_assoc();
                                
                                if ($user) {
                                    $verify_status = $user['verify_status'];
                            
                                    // Determine label text and color based on verify_status
                                    if ($verify_status) {
                                        $label_text = "Verified";
                                        $label_color = "green";
                                    } else {
                                        $label_text = "Not Verified";
                                        $label_color = "red";
                                    }
                                } else {
                                    // Handle case where user with email is not found
                                    $label_text = "User Not Found";
                                    $label_color = "black"; // Default color or handle as needed
                                }
                            } else {
                                // Redirect or handle case where session email is not set
                                header("Location: ../settings/settings.php"); // Redirect to login page or handle accordingly
                                exit();
                            }
                            
                            // Generate a unique token for the OTP request
                            if (!isset($_SESSION['otp_token'])) {
                                $otp_token = bin2hex(random_bytes(16));
                                $_SESSION['otp_token'] = $otp_token;
                            }
                            
                            // Initialize status variables
                            $status = '';
                            
                            // Handle sending OTP email
                            if (isset($_POST['send_code'])) {
                                if ($_POST['otp_token'] == $_SESSION['otp_token']) {
                                    // Generate OTP (example: 6-digit random number)
                                    $otp_code = mt_rand(100000, 999999);
                            
                                    // Save OTP code (for validation later)
                                    $_SESSION['otp_code'] = $otp_code;
                            
                                    // Send OTP code via email
                                    try {
                                        $mail->setFrom('your_email@gmail.com', 'Crazy Sale');
                                        $mail->addAddress($user_email); // User's email address
                                        $mail->Subject = 'Verification Code';
                                        $mail->Body = 'Your verification code is: '. $otp_code;
                            
                                        $mail->send();
                                        $status = "success|OTP sent successfully!";
                                        
                                        // Set session variable to indicate OTP has been sent
                                        $_SESSION['otp_sent'] = true;
                                        $_SESSION['otp_timer'] = time() + 30; // set timer for 1 minute
                                        $_SESSION['otp_token'] = bin2hex(random_bytes(16)); // regenerate token
                                    } catch (Exception $e) {
                                        $status = "error|Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                    }
                                } else {
                                    $status = "error|Invalid token. Please try again.";
                                }
                            }
                            
                            // Handle OTP verification
                            if (isset($_POST['verify_account'])) {
                                if (isset($_POST['otp']) && $_POST['otp'] == $_SESSION['otp_code']) {
                                    // Update verify_status in the users table
                                    $query = "UPDATE users SET verify_status = 1 WHERE email = ?";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param("s", $user_email);
                                    if ($stmt->execute()) {
                                        $status = "success|Account verified successfully!";
                                        $verify_status = 1; // Update the verify_status variable
                                        $label_text = "Verified"; // Update the label text
                                    } else {
                                        $status = "error|Failed to verify account. Please try again.";
                                    }
                                } else {
                                    $status = "error|Invalid OTP code. Please try again.";
                                }
                            }
                            
                            // Set active tab in session
                            if (isset($_POST['send_code'])) {
                                $_SESSION['active_tab'] = 'account-verification';
                            } else {
                                $_SESSION['active_tab'] = 'account-general';
                            }
                            ?>
                            
                            <div class="tab-pane fade" id="account-verification">
                                <div class="card-body pb-2">
                                    <?php
                                    // Display status message if set
                                    if (!empty($status)) {
                                        list($type, $message) = explode('|', $status);
                                        if ($type === 'success') {
                                            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
                                        } elseif ($type === 'error') {
                                            echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
                                        }
                                    }
                                    ?>
                                    <form id="verificationForm" method="post" action="">
                                        <input type="hidden" name="otp_token" value="<?php echo $_SESSION['otp_token']; ?>">
                                        <div class="form-group">
                                            <label class="form-label <?php echo $verify_status ? 'text-success' : 'text-danger'; ?>"><?php echo $label_text; ?></label>
                                            <?php if (!$verify_status): ?>
                                            <div class="input-group">
                                                <input type="input" class="form-control" name="otp">
                                                <div class="input-group-append">
                                                    <?php if (!isset($_SESSION['otp_sent']) || $_SESSION['otp_timer'] < time()): ?>
                                                        <button id="sendCodeBtn" class="btn btn-primary" name="send_code">Send code</button>
                                                    <?php else: ?>
                                                        <button id="sendCodeBtn" class="btn btn-primary" type="submit" name="verify_account">Submit</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <span id="timer" style="display: none;"></span>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label class="form-label">Current password</label>
                                            <input type="password" class="form-control" name="current_password">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">New password</label>
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Repeat new password</label>
                                            <input type="password" class="form-control" name="confirm_password">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="save_password_changes">Save changes</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label class="form-label">Birthday</label>
                                            <input type="text" class="form-control" name="birthday">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Country</label>
                                            <select class="custom-select" name="country">
                                                <option selected>Select Country</option>
                                                <option>LB</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="change_info">Change info</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-contacts">
    <div class="card-body pb-2">
        <form method="post" action="">
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="contacts" value="<?php echo isset($user['contacts']) ? htmlspecialchars($user['contacts']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="change_contacts">Change Number</button>
        </form>
    </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
   <!-- Display messages -->
   <?php
    if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'];
        echo "<h4 style='color:$type'>$message</h4>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>

<script>
    document.getElementById("cancel").addEventListener("click", function() {
        window.location.href = "../settings/settings.php";
    });
</script>
<script>
    $(document).ready(function() {
// Function to handle file input change
$('.account-settings-fileinput').on('change', function() {
    var input = $(this)[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Display the selected image preview
            $('.media img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
});
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
// Get the active tab from the session variable
var activeTab = '<?php echo isset($_SESSION['active_tab']) ? $_SESSION['active_tab'] : 'account-general'; ?>';

// Find the corresponding tab link and tab content
var activeTabLink = document.querySelector('.list-group-item[href="#' + activeTab + '"]');
var activeTabContent = document.querySelector('#' + activeTab);

if (activeTabLink && activeTabContent) {
    // Remove 'active' class from all tab links and contents
    document.querySelectorAll('.list-group-item').forEach(function(link) {
        link.classList.remove('active');
    });
    document.querySelectorAll('.tab-pane').forEach(function(tab) {
        tab.classList.remove('show', 'active');
    });

    // Add 'active' class to the selected tab link and content
    activeTabLink.classList.add('active');
    activeTabContent.classList.add('show', 'active');
}

// Check if OTP has been sent and timer is active
if (<?php echo isset($_SESSION['otp_timer']) && $_SESSION['otp_timer'] > time() ? 'true' : 'false'; ?>) {
    var timer = <?php echo $_SESSION['otp_timer'] - time(); ?>;
    var interval = setInterval(function() {
        timer--;
        document.getElementById('sendCodeBtn').classList.add('disabled-btn');
        document.getElementById('sendCodeBtn').classList.remove('active-btn');
        document.getElementById('sendCodeBtn').innerHTML = 'Submit (' + timer + ' seconds remaining)';
        if (timer <= 0) {
            clearInterval(interval);
            document.getElementById('sendCodeBtn').classList.add('active-btn');
            document.getElementById('sendCodeBtn').classList.remove('disabled-btn');
            document.getElementById('sendCodeBtn').innerHTML = 'Send code';
        }
    }, 1000);
}
});

// Add event listener to the send code button
document.getElementById('sendCodeBtn').addEventListener('click', function() {
// Start the timer only if the button is clicked
var timer = 30;
var interval = setInterval(function() {
    timer--;
    document.getElementById('sendCodeBtn').innerHTML = 'Submit (' + timer + ' seconds remaining)';
    document.getElementById('sendCodeBtn').classList.add('disabled-btn');
    document.getElementById('sendCodeBtn').classList.remove('active-btn');
    if (timer <= 0) {
        clearInterval(interval);
        document.getElementById('sendCodeBtn').innerHTML = 'Send code';
        document.getElementById('sendCodeBtn').classList.add('active-btn');
        document.getElementById('sendCodeBtn').classList.remove('disabled-btn');
    }
}, 1000);
});
</script>