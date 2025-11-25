<?php require_once('dashboard.view.php'); ?>
    <div class="account__section">
        <h1>Personal Information</h1>
        <div class="account__settings__item">
            <div class="account__settings__content">
                <p>Username</p>
                <p class="account__subtext"><?php echo $user['username'] ?></p>
            </div>
            <button class="account__button" id="editUsername">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z"/></svg>
                edit
            </button>
        </div>
        <div class="account__settings__item">
            <div class="account__settings__content">
                <p>Email</p>
                <p class="account__subtext"><?php echo $user['email'] ?></p>
            </div>
            <button class="account__button" id="editEmail">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z"/></svg>
                edit
            </button>
        </div>
        <div class="account__settings__item">
            <div class="account__settings__content">
                <p>Password</p>
                <p class="account__subtext"><?php echo str_repeat('*', 20)?></p>
            </div>
            <button class="account__button" id="editPassword">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z"/></svg>
                edit
            </button>
        </div>
    </div>
</div>
<div class="forms hidden">
    <div class="form__popup hidden" id="changeUsername">
        <div class="form__popup__head">
            <h2>Change Username</h2>
            <span class="close-btn">&times;</span>
        </div>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <button type="submit" class="account__button">save</button>
        </form>
    </div>
    <div class="form__popup hidden" id="changeEmail">
        <div class="form__popup__head">
            <h2>Change email address</h2>
            <span class="close-btn">&times;</span>
        </div>
        <div>
            <p>Current email address:</p>
            <span><?php echo $user['email'] ?></span>
        </div>
        <form action="" method="post">
            <label for="email">New email address:</label>
            <input type="email" name="email" id="email" required>
            <label for="confirmEmail">Confirm your new email address:</label>
            <input type="email" name="confirmEmail" id="confirmEmail" required>
            <button type="submit" class="account__button">save</button>
        </form>
    </div>
    <div class="form__popup hidden" id="changePassword">
        <div class="form__popup__head">
            <h2>Change Password</h2>
            <span class="close-btn">&times;</span>
        </div>
        <form action="" method="post">
            <label for="password">Enter password:</label>
            <input type="password" name="password" id="password" required>
            <label for="newPassword">Enter new password:</label>
            <input type="password" name="newPassword" id="newPassword" required>
            <label for="confirmNewPassword">Confirm new password</label>
            <input type="password" name="confirmNewPassword" id="confirmNewPassword" required>
            <button type="submit" class="account__button">save</button>
        </form>
    </div>
</div>
<script type="module" src="<?= ROOT ?>assets/js/account-edit.js"></script>