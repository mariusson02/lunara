<div class="admin-wrapper">
    <div class="admin__dashboard">
        <div class="admin__dashboard__profile">
            <div class="profile-picture">
                <h2>Admin Dashboard</h2>
            </div>
            <div>
                <p><?php echo $user['username'] ?></p>
                <p class="admin__subtext"><?php echo $user['email'] ?></p>
            </div>
        </div>
        <ul class="admin__dashboard__list">
            <li<?= $name === 'users' ? ' class="active"' : '' ?>><a href="/admin/users">Users</a></li>
            <li<?= $name === 'nfts' ? ' class="active"' : '' ?>><a href="/admin/nfts">NFTs</a></li>
            <li<?= $name === 'transactions' ? ' class="active"' : '' ?>><a href="/admin/transactions">Transactions</a></li>
        </ul>
    </div>