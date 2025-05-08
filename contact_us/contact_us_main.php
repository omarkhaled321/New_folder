<div class="container">
    <div class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>
    </div>
    <div class="contact-container">
        <form action="sendrequest.php" method="POST" class="contact-left">
            <div class="contact-left-title">
                <h2>Send Your Problem</h2>
                <hr>
            </div>
            <input type="text" name="name" placeholder="Enter Your Name" class="contact-inputs" required>
            <input type="email" name="email" placeholder="Enter Your email" class="contact-inputs" required>
            <textarea name="problem" placeholder="Enter Your Problem" class="contact-inputs" required></textarea>
            <button type="submit">Submit <img src="./img/arrow.png" alt=""></button>
        </form>
        <div class="contact-right">
            <img src="./img/mail.png" alt="">
        </div>
    </div>
</div>