<?php require_once('dashboard.view.php'); ?>
    <div class="admin__section">
        <div class="admin__section__head">
            <h1>Users</h1>
            <button id="newUser" class="admin__button">Add User</button>
        </div>
        <?php if ($users) :?>
            <div class="admin__content">
                <table class="admin__content__table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>username</th>
                            <th>email</th>
                            <th>wallet</th>
                            <th>role</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $entry) : ?>
                        <tr class="admin__content__tr">
                            <td>#<?= $entry[UserModel::ID] ?></td>
                            <td><?= $entry[UserModel::USERNAME] ?></td>
                            <td><?= $entry[UserModel::EMAIL] ?></td>
                            <td class="<?=$entry[UserModel::WALLET] ? '' : 'empty' ?>"><?= $entry[UserModel::WALLET] ? maskWalletAddress($entry[UserModel::WALLET]) : 'empty' ?></td>
                            <td><?= RoleModel::mapRoleIdToName($entry[UserModel::ROLE_ID]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>No users are registered.</p>
        <?php endif; ?>
    </div>
</div>
<div class="admin__actions__modal hidden">
    <div class="admin__actions__modal__content">
        <div class="modal__content__head">
            <h2>Manage User</h2>
            <span class="close-btn">&times;</span>
            <input type="hidden" id="userId" value="" readonly>
        </div>
        <label for="actionSelect">Choose an action:</label>
        <select id="actionSelect">
            <option value="default" selected>Select an action</option>
            <option value="editUser">Edit Details</option>
            <option value="changeRole">Change Role</option>
            <option value="handleUserAction">User actions</option>
        </select>
        <div id="admin__actions__modal__body">
            <div id="default" class="modal__form__container hidden">
                <p>Selected User: </p>
                <form id="selectedUser" class="model__body__form">
                    <label for="username">Username:</label>
                    <input type="text" id="username" value="" readonly>

                    <label for="email">Email:</label>
                    <input type="email" id="email" value="" readonly>

                </form>
            </div>
            <div id="editUser" class="modal__form__container hidden">
                <form class="model__body__form" id="editUser">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="" required>

                    <button type="submit" class="admin__button">Save Changes</button>
                </form>
            </div>
            <div id="handleUserAction" class="modal__form__container hidden">
                <form class="model__body__form" id="handleUserAction">
                    <label for="action">Select Action</label>
                    <select name="action" id="action" required>
                        <option value="deactivate" selected>Deactivate</option>
                        <option value="reactivate">Reactivate</option>
                        <option value="delete">Delete</option>
                    </select>

                    <label for="username">Username:</label>
                    <input type="text" id="username" value="" readonly>

                    <label for="email">Email:</label>
                    <input type="email" id="email" value="" readonly>

                    <p id="actionMessage">Are you sure you want to deactivate this user?</p>
                    <button type="submit" class="admin__button">Yes, deactivate</button>
                </form>
            </div>
            <div id="changeRole" class="modal__form__container hidden">
                <form class="model__body__form" id="changeRole">
                    <label for="role">Select role:</label>
                    <select id="role" name="role">
                        <option value="1">User</option>
                        <option value="2">Admin</option>
                    </select>
                    <button type="submit" class="admin__button">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="admin__actions__user__modal hidden" id="addUserModal">
    <div class="admin__actions__modal__content">
        <div class="modal__content__head">
            <h2>Add New User</h2>
            <span class="close-btn" id="closeAddUserModal">&times;</span>
        </div>
        <form class="model__body__form" id="addUser">
            <label for="addUsername">Username:</label>
            <input type="text" id="addUsername" name="username" required>

            <label for="addEmail">Email:</label>
            <input type="email" id="addEmail" name="email" required>

            <label for="addRole">Select Role:</label>
            <select id="addRole" name="role">
                <option value="1">User</option>
                <option value="2">Admin</option>
            </select>

            <label for="addPassword">Password:</label>
            <input type="password" id="addPassword" name="password" required>

            <button type="submit" class="admin__button">Add User</button>
        </form>
    </div>
</div>
<script src="<?= ROOT ?>assets/js/admin.js"></script>
