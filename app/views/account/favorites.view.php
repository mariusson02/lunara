<?php require_once 'dashboard.view.php'; ?>
<div class="account__section">
    <h1>Favorites</h1>
    <?php if ($favorites) : ?>
        <?php foreach ($favorites as $nft) : ?>
            <div class="account__favorites__wrapper">
                <div class="account__favorites">
                    <img src="<?= ROOT ?>assets/models/<?= $nft[NftModel::IMG] ?>/thumbnail.png" alt="<?= $nft['name']?>">
                    <div>
                        <p><?= $nft[NftModel::NAME] ?></p>
                        <p><?= $nft[NftModel::SUBTITLE] ?></p>
                    </div>
                </div>
                <button class="account__button__show" onclick="redirect('/nft?id=<?= $nft[NftModel::ID] ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="m380-300 280-180-280-180v360ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                    show
                </button>
            </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p>You have no favorites</p>
    <?php endif; ?>
</div>
</div>
<script type="module" src="<?= ROOT ?>assets/js/account-edit.js"></script>