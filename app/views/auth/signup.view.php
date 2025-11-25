
<div class="signup-container">
    <div class="signup-box">
        <h1 class="signup-box-heading">Registration</h1>
        <form class="signup-box-form" action="/auth/signup" method="POST">
            <input class="signup-box-input" type="text" id="username" name="username" placeholder="Username" required>
            <br>
            <input class="signup-box-input" type="email" id="email" name="email" placeholder="Email" required>
            <br>
            <input class="signup-box-input" type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <input class="signup-box-input" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            <br>
            <button class="signup-box-button" type="submit">Signup</button>
        </form>
<?php if(isset($errors) && count($errors) > 0): ?>
    <div>
        <?php foreach($errors as $error): ?>
            <div>
                <?= $error ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    </div>
</div>

<video class="background-video" autoplay loop muted>
    <source src="<?= ROOT ?>assets/videos/stars.mp4" type="video/mp4">
</video>
<script src="<?= ROOT ?>assets/js/signup.js"></script>