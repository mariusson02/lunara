<?php require_once('dashboard.view.php'); ?>
<div class="admin__section">
    <h1>NFTs</h1>
    <?php if ($nfts) :?>
        <div class="admin__content">
            <table class="admin__content__table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>type</th>
                    <th>price</th>
                    <th>owner</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($nfts as $entry) : ?>
                    <tr class="admin__content__tr">
                        <td>#<?= $entry[NftModel::ID] ?></td>
                        <td><?= $entry[NftModel::NAME] ?></td>
                        <td><?= $entry[NftModel::TYPE] ?></td>
                        <td><?= $entry[NftModel::PRICE] ?></td>
                        <td class="<?=$entry[NftModel::OWNER_ID] ? '' : 'empty' ?>">
                            <?php if (!$entry[NftModel::OWNER_ID]) : ?>
                                empty
                            <?php else : ?>
                            <span class="sub">[ <?= $entry[NftModel::OWNER_ID] ?> ]</span>
                            <span><?= $entry[UserModel::USERNAME] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No NFTs were found.</p>
    <?php endif; ?>
</div>
</div>
<script src="<?= ROOT ?>assets/js/admin.js"></script>
