<?php
    $soldOut = isset($nft[NftModel::OWNER_ID]);
?>
<div id="is-available" data-is-available="<?= $soldOut ? 1 : 0 ?>" style="display: none"></div>

<canvas id="model-display" data-path="<?php echo $nft[NftModel::IMG]?>" data-scale="<?= $nft[NftModel::SCALE] ?: 1 ?>"></canvas>
<section class="nft-section">
    <div class="nft-section__description"  id="nft-section__0" style="margin-top: 5rem">
        <h1 class="nft-section__title reveal"><?php echo $nft[NftModel::NAME]?></h1>
        <hr class="horizontal-ruler reveal">
        <h3 class="nft-section__subtext reveal"><?php echo $nft[NftModel::DESCRIPTION]?></h3>
        <button class="buy-now holo reveal <?= $soldOut ? "inverse" : ""?>" onclick="window.location.href = '#nft-section__3'">
            <?= $soldOut ? "sold out" : "add to cart" ?>
        </button>
    </div>
</section>
<section class="nft-section" id="nft-section__1">
    <h3 class="nft-section__subtitle reveal"><?php echo $nft[NftModel::SUBTITLE]?></h3>
    <h1 class="nft-section__title reveal"><?php echo $nft[NftModel::NAME]?></h1>
    <hr class="horizontal-ruler reveal" style="margin-left: 0;">
    <p class="nft-section__text reveal"><?php echo $nft[NftModel::SECTION1]?></p>
</section>
<section class="nft-section" id="nft-section__2">
    <hr class="horizontal-ruler reveal" style="margin-left: 0;">
    <p class="nft-section__text reveal"><?php echo $nft[NftModel::SECTION2]?></p>
</section>
<section class="nft-section" id="nft-section__3">
    <div class="nft reveal">
        <div class="nft__description">
            <p><?php echo $nft[NftModel::NAME]?></p>
            <div class="favorite" data-id="<?= $nft[NftModel::ID] ?>"></div>
            <p><?php echo $nft[NftModel::SECTION3]?></p>
        </div>
        <div class="nft__price">
            <div class="nft__price-wrapper">
                <p>price</p>
                <div class="nft__price-tag">
                    <p><?php echo $nft[NftModel::PRICE]?> LUN</p>
                    <div class="nft__price-coin"></div>
                </div>
            </div>
            <button
                class="buy-now holo with-tooltip <?= $soldOut ? "inverse" : ""?>"
                id="buy"
                data-id="<?= $nft[NftModel::ID]?>"
                data-tooltip="<?= Middleware::isAdmin() ? 'admins are not supposed to buy NFTs' : ($soldOut ? 'SOLD OUT' : '')?>"
                <?= Middleware::isAdmin() || $soldOut ? 'disabled' : '' ?>
            >
               <?= $soldOut ? "sold out" : "add to cart" ?>
            </button>
        </div>
    </div>
</section>
<script type="module" src="<?= ROOT ?>assets/js/detail.js"></script>