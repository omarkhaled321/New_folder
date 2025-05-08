<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/login.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
        <form action="signin.php" method="POST" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <input type="submit" value="Login" class="btn solid" />
          <p class="social-text"><a href="forgot_password.php">Forgot password?</a></p>
          </form>

          <!-- Sign Up Form -->
        <form action="signup.php" method="POST" class="sign-up-form" onsubmit="return validateSignUpForm()">
          <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="username" name="username" placeholder="Username" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" placeholder="Email" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" id="signup-password" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="confirm_password" placeholder="Confirm Password" id="signup-confirm-password" required />
            </div>

            <!-- Terms and Conditions Checkbox -->
            <div style="margin: 10px 0; font-size: 14px;">
              <input type="checkbox" id="terms-checkbox" />
              <label for="terms-checkbox">I agree to the <a href="#">Terms & Conditions</a></label>
            </div>

            <input type="submit" class="btn" value="Sign up" />
          </form>
        </div>
      </div>

      <div class="panels-container">
        <!-- Left Panel -->
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">Sign up</button>
          </div>
          <img src="../img/log.svg" class="image" alt="" />
        </div>

        <!-- Right Panel -->
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">Sign in</button>
          </div>
          <img src="../img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script>
      const sign_in_btn = document.querySelector("#sign-in-btn");
      const sign_up_btn = document.querySelector("#sign-up-btn");
      const container = document.querySelector(".container");

      sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
      });

      sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign-up-mode");
      });

      function validateSignUpForm() {
        const password = document.getElementById("signup-password").value;
        const confirmPassword = document.getElementById("signup-confirm-password").value;
        const termsChecked = document.getElementById("terms-checkbox").checked;

        if (password !== confirmPassword) {
          alert("Passwords do not match!");
          return false;
        }

        if (!termsChecked) {
          alert("You must agree to the Terms & Conditions.");
          return false;
        }

        return true;
      }
    </script>
  </body>
</html>
