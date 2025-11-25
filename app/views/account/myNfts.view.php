<?php require_once 'dashboard.view.php'; ?>
    <div class="account__section">
        <h1>My NFTs</h1>
        <?php if (isset($myNfts)) : ?>
            <?php foreach ($myNfts as $nft): ?>
                <div class="account__nfts__wrapper">
                    <div class="account__nft">
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
                    <button class="account__button sell" id="editOwnership" data-nft-id="<?= $nft[NftModel::ID] ?>" data-nft-name="<?= $nft[NftModel::NAME] ?>">
                        <img src="<?= ROOT ?>assets/svg/price-tag.svg" alt="">sell
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
        <p>You currently own no Nfts.</p>
        <?php endif; ?>
    </div>
</div>
<div class="forms hidden">
    <div class="form__popup hidden" id="changeOwnership">
        <div class="form__popup__head">
            <h2>Do you really want to sell this NFT?</h2>
            <span class="close-btn">&times;</span>
        </div>
        <form action="" method="POST">
            <input
                    name="nftId"
                    value=""
                    type="hidden"
            required readonly>
            <button type="submit" class="account__button">confirm</button>
        </form>
    </div>
</div>
<script type="module" src="<?= ROOT ?>assets/js/account-edit.js"></script>