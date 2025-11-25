<div class="account-wrapper">
    <div class="account__dashboard">
        <div class="account__dashboard__profile">
            <div class="profile-picture">
                <img src="<?= ROOT ?>assets/images/profile-picture-default.png" alt="Default Profile Picture">
            </div>
            <div>
                <p><?php echo $user['username'] ?></p>
                <p class="account__subtext"><?php echo $user['email'] ?></p>
            </div>
        </div>
        <ul class="account__dashboard__list">
            <li<?= $name === 'edit' ? ' class="active"' : '' ?>><a href="/account/edit">Edit Profile</a></li>
            <?php if (!Middleware::isAdmin()) : ?>
            <li<?= $name === 'wallet' ? ' class="active"' : '' ?>><a href="/account/wallet">Wallet</a></li>
            <li<?= $name === 'myNfts' ? ' class="active"' : '' ?>><a href="/account/myNfts">My NFTs</a></li>
            <li<?= $name === 'favorites' ? ' class="active"' : '' ?>><a href="/account/favorites">Favorites</a></li>
            <?php endif; ?>
        </ul>
    </div>