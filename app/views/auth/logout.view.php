<div class="logout-container">
    <div class="logout-box">
<h1>
    <?php if(isset($data['success']) && $data['success']):?>
        Successfully logged out
    <?php else: ?>
        An error occurred while logging out
    <?php endif;?>
</h1>
        <div class="logout-box-buttons">
            <button class="logout-box-button" onclick="redirect('/')">Home</button>
            <button class="logout-box-button" onclick="redirect('/auth/login')">Login</button>
        </div>
    </div>
</div>

<video class="background-video" autoplay loop muted>
    <source src="<?= ROOT ?>assets/videos/stars.mp4" type="video/mp4">
</video>