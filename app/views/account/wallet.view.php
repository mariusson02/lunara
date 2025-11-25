<?php require_once 'dashboard.view.php'; ?>
    <div class="account__section">
        <h1>Wallet & Transactions</h1>
        <div class="account__wallet">
            <div class="account__wallet__card">
                <div>
                    <span>
                        <img src="<?= ROOT ?>assets/images/logo_dark.png" alt="Logo" class="account__wallet__card__logo">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1d1d1d"><path d="M200-200v-560 560Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v100h-80v-100H200v560h560v-100h80v100q0 33-23.5 56.5T760-120H200Zm320-160q-33 0-56.5-23.5T440-360v-240q0-33 23.5-56.5T520-680h280q33 0 56.5 23.5T880-600v240q0 33-23.5 56.5T800-280H520Zm280-80v-240H520v240h280Zm-160-60q25 0 42.5-17.5T700-480q0-25-17.5-42.5T640-540q-25 0-42.5 17.5T580-480q0 25 17.5 42.5T640-420Z"/></svg>
                    </span>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1d1d1d"><path d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70q66 0 121 33t87 87h432v240h-80v120H600v-120H488q-32 54-87 87t-121 33Zm0-80q66 0 106-40.5t48-79.5h246v120h80v-120h80v-80H434q-8-39-48-79.5T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-80q33 0 56.5-23.5T360-480q0-33-23.5-56.5T280-560q-33 0-56.5 23.5T200-480q0 33 23.5 56.5T280-400Zm0-80Z"/></svg>
                        <?php if ($user['wallet']) :?>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1d1d1d"><path d="M480-120q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM254-346l-84-86q59-59 138.5-93.5T480-560q92 0 171.5 35T790-430l-84 84q-44-44-102-69t-124-25q-66 0-124 25t-102 69ZM84-516 0-600q92-94 215-147t265-53q142 0 265 53t215 147l-84 84q-77-77-178.5-120.5T480-680q-116 0-217.5 43.5T84-516Z"/></svg>
                        <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1d1d1d"><path d="M790-56 414-434q-47 11-87.5 33T254-346l-84-86q32-32 69-56t79-42l-90-90q-41 21-76.5 46.5T84-516L0-602q32-32 66.5-57.5T140-708l-84-84 56-56 736 736-58 56Zm-310-64q-42 0-71-29.5T380-220q0-42 29-71t71-29q42 0 71 29t29 71q0 41-29 70.5T480-120Zm236-238-29-29-29-29-144-144q81 8 151.5 41T790-432l-74 74Zm160-158q-77-77-178.5-120.5T480-680q-21 0-40.5 1.5T400-674L298-776q44-12 89.5-18t92.5-6q142 0 265 53t215 145l-84 86Z"/></svg>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <span><?= $user['username']?></span>
                    <span><?= $user['wallet'] ? maskWalletAddress($user['wallet']) : ''?></span>
                </div>
            </div>
            <div class="account__wallet__info">
                <div>
                    <span>Wallet owner:</span>
                    <span class="account__wallet__info__content"><?= $user['username']?></span></div>
                <div>
                    <span>Status:</span>
                    <span class="account__wallet__info__content"><?= $user['wallet'] ? 'connected' : 'not connected'?></span></div>
                <div>
                    <span>Wallet ID:</span>
                    <span class="account__wallet__info__content"><?= $user['wallet'] ? maskWalletAddress($user['wallet']) : 'not connected'?></span></div>
                <button class="account__button" id="editWallet">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z"/></svg>
                    link/edit
                </button>
            </div>
        </div>
        <div class="account__wallet__transactions">
            <h2>Your Transactions</h2>
            <?php if ($transactions) :?>
                <div class="account__transaction">
                    <div class="account__transaction__table">
                        <div class="table-header">
                            <div class="header__item"><a id="name" class="filter__link" href="#">Transaction ID</a></div>
                            <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Date</a></div>
                            <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Item</a></div>
                            <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Price</a></div>
                        </div>
                        <?php foreach ($transactions as $transaction) : ?>
                        <div class="table-content">
                            <div class="table-row">
                                <div class="table-data">#<?= $transaction[TransactionModel::ID] ?></div>
                                <div class="table-data"><?= parseTimestamp($transaction[TransactionModel::TIMESTAMP]) ?></div>
                                <div class="table-data">
                                    <p class="table-data__item"><?= $transaction[NftModel::NAME] ?></p>
                                    <p class="table-data__item sub"><?= $transaction[NftModel::SUBTITLE] ?></p>
                                </div>
                                <div class="table-data"><?= $transaction[NftModel::PRICE] ?> LUN</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <p>You have not made any transactions.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="forms hidden">
    <div class="form__popup hidden" id="changeWallet">
        <div class="form__popup__head">
            <h2>Link or edit your wallet information</h2>
            <span class="close-btn">&times;</span>
        </div>
        <form action="" method="post">
            <label for="wallet">Wallet ID:</label>
            <input type="text" name="wallet" id="wallet" required>
            <button type="submit" class="account__button">save</button>
        </form>
    </div>
</div>
<script type="module" src="<?= ROOT ?>assets/js/account-edit.js"></script>