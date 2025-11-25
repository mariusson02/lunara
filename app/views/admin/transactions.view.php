<?php require_once('dashboard.view.php'); ?>
<div class="admin__section">
    <h1>Transactions</h1>
    <?php if ($transactions) :?>
        <div class="admin__content">
            <table class="admin__content__table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>date</th>
                    <th>nft</th>
                    <th>user</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($transactions as $entry) : ?>
                    <tr class="admin__content__tr">
                        <td>#<?= $entry[TransactionModel::ID] ?></td>
                        <td><?= parseTimestamp($entry[TransactionModel::TIMESTAMP]) ?></td>
                        <td>
                            <span class="sub">[ <?= $entry[TransactionModel::NFT_ID] ?> ]</span>
                            <span><?= $entry[NftModel::NAME] ?></span>
                        </td>
                        <td>
                            <span class="sub">[ <?= $entry[TransactionModel::USER_ID] ?> ]</span>
                            <span><?= $entry[UserModel::USERNAME] ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No transaction were made yet.</p>
    <?php endif; ?>
</div>
</div>
<script src="<?= ROOT ?>assets/js/admin.js"></script>
