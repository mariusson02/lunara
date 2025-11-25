
<div class="login-container">
    <div class="login-box">
        <h1 class="login-box-heading">Login</h1>
        <form class="login-box-form" action="/auth/login" method="POST">
            <input class="login-box-input" type="text" id="username" name="username" placeholder="Username" required>
            <br>
            <input class="login-box-input" type="password" id="password" name="password" placeholder="Password" required>

            <p class="login-box-register-text">
                Don't have an account yet?
                <button class="login-box-register-button" type="button" onclick="redirect('signup')">Register here</button>
            </p>

            <button class="login-box-button" type="submit">Login</button>
        </form>

<?php if(isset($errors) && count($errors) > 0): ?>
    <div class="login-error">
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
    <source src="<?= ROOT ?>assets/videos/Interstellar_Gargantua.mp4" type="video/mp4">
</video>