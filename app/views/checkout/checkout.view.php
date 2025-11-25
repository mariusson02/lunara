<?php
$noUser = !isset($user);
$noWallet = !isset($user[UserModel::WALLET]);

$noUserMessage = "Log in to purchase!";
$noWalletMessage = "Haven't connected your wallet yet?"

?>

<canvas id="checkout__bg"></canvas>

<div class="checkout__page-container">
    <h1>Checkout</h1>
    <div class="checkout__container">
        <div class="checkout__cart">
            <h2>your cart</h2>
            <div class="checkout__cart__info">
                <span id="amount-of-items"></span>
                <button id="checkout-clear" class="secondary holo inverse">Clear All</button>
            </div>
            <div id="checkout-items"></div>
        </div>
        <div class="checkout__overview">
            <div class="checkout__price-overview">
                <h2>total <span id="checkout-total"></span></h2>
                <button
                        id="checkout-purchase"
                        class="secondary holo with-tooltip"
                        <?= $noUser || $noWallet ? 'disabled' : ''?>
                        data-tooltip="<?= $noUser ? $noUserMessage : ($noWallet ? $noWalletMessage : '')?>"
                >
                    Complete Purchase
                </button>
            </div>
            <?php if ($noUser): ?>
                <div class="checkout__guest-auth">
                    <h2><?= $noUserMessage ?></h2>
                    <button id="checkout-login" class="secondary holo" onclick="redirect('auth/login')">
                        Login
                    </button>
                    <button id="checkout-signup" class="secondary holo" onclick="redirect('auth/signup')">
                        Signup
                    </button>
                </div>
            <?php elseif ($noWallet): ?>
                <div class="checkout__connect-wallet"
                    <h2><?= $noWalletMessage ?></h2>
                    <button id="connect-wallet" class="secondary holo" onclick="redirect('account/wallet')">Connect Wallet</button>
                </div>
            <?php else: ?>
                <div class="checkout__connect-wallet"
                    <h2>Have a new wallet?</h2>
                    <button id="connect-wallet" class="secondary holo" onclick="redirect('account/wallet')">Update Wallet</button>
                </div>
             <?php endif; ?>
        </div>
    </div>
</div>

<script type="module" src="<?= ROOT ?>assets/js/checkout.js" defer></script>